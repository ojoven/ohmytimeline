<?php
App::uses('AppController', 'Controller');
App::uses('ProgressBar', 'Lib');

class IndexController extends AppController {

	public $uses = array('TwitterList', 'User');

	/** INDEX **/
	public function index() {

		$this->clearSessionIfIsNotAuthorizedFromTwitter();
		$authenticated = $this->_setAuthenticated();
		$this->_redirectIfAlreadyOMTListCreated($authenticated);
		$this->_setFromAuthorized();

	}

	private function _setAuthenticated() {
		$authenticated = false;
		$user = $this->Session->read('user'); // We'll first check if the user is logged in OMT
		if ($user) {
			$connection = $this->TwitterList->getConnection();
			if ($connection) {
				$authenticated = true;
				$this->set('user', $user);
			} else {
				$this->Session->destroy();
				$this->set('authenticated', false);
			}
		}

		$this->set('authenticated', $authenticated);
		return $authenticated;
	}

	private function _setFromAuthorized() {

		$this->set('fromAuthorized', $this->Session->read('fromAuthorized'));
		$this->Session->delete('fromAuthorized');
	}

	private function _redirectIfAlreadyOMTListCreated($authenticated) {

		if ($authenticated) {

			$user = $this->Session->read('user');
			$this->loadModel('User');
			$userDB = $this->User->findByUserId($user->id);
			$username = $userDB['User']['username'];
			$listSlug = $userDB['User']['omt_list_slug'];
			$listId = $userDB['User']['omt_list_id'];

			$this->loadModel('TwitterList');
			$lists = $this->TwitterList->getListsUser($user);
			foreach ($lists as $list) {
				if ($list->id_str === $listId) {

					// Redirect to view list page
					$url = '/list/' . $username . '/' . $listSlug;
					$this->redirect(Router::url($url));
				}
			}
		}

	}

	/** VIEW **/
	public function viewlist() {

		$user = $this->request->params['username'];
		$slug = $this->request->params['slug'];

		$this->set('username', $user);
		$this->set('slug', $slug);

		$this->_setAuthenticated();
	}

	/** LOGOUT **/
	public function logout() {
		$this->Session->destroy();
		$this->redirect(Router::url("/",true));
	}

	/** TWITTER **/
	// AUTHORIZE
	public function authorize() {

		$connection = $this->TwitterList->getTmpConnection();
		$callbackUrl = Router::url('/api/callback',true);
		$request_token = $connection->getRequestToken($callbackUrl);

		$token = $request_token['oauth_token'];
		$this->Session->write('oauth_token',$token);
		$this->Session->write('oauth_token_secret',$request_token['oauth_token_secret']);

		// Save in Session if author should be followed
		$follow = (isset($_POST['follow']) && $_POST['follow'] === '1');
		$this->Session->write('follow', $follow);

		/* If last connection failed don't display authorization link. */
		switch ($connection->http_code) {
			case 200:
				/* Build authorize URL and redirect user to Twitter. */
				$url = $connection->getAuthorizeURL($token);
				$this->redirect($url);
				break;
			default:
				/* Show notification if something went wrong. */
				echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
	}

	// CALLBACK
	public function callback() {

		if (!isset($_REQUEST['oauth_token']) || isset($_REQUEST['oauth_token']) && $this->Session->read('oauth_token') !== $_REQUEST['oauth_token']) {
			header('Location: '.Router::url('/?not_authorized'));
		}

		$params['oauth_token'] = $this->Session->read('oauth_token');
		$params['oauth_token_secret'] = $this->Session->read('oauth_token_secret');
		$connection = $this->TwitterList->getOauthConnection($params);

		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$this->Session->write('access_token',$access_token);

		$this->Session->delete('oauth_token');
		$this->Session->delete('oauth_token_secret');

		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if (200 == $connection->http_code) {

			// Let the system know that we come from authorized page to automatically trigger the list creation
			$this->Session->write('fromAuthorized', true);

			// Get the Twitter user information
			$user = $connection->get('account/verify_credentials');

			// Save the User in the Session
			$this->Session->write('user', $user);

			// Save the user in the database
			$this->loadModel('User');
			$previousUser = $this->User->findByUserId($user->id);
			if ($previousUser) {
				$this->User->id = $previousUser['User']['id'];
			} else {
				$this->User->create();
			}

			$data = array(
				'user_id' => $user->id,
				'username' => $user->screen_name,
				'oauth_token' => $access_token['oauth_token'],
				'oauth_token_secret' => $access_token['oauth_token_secret'],
			);

			$this->User->save($data);
			$userDb = $this->User->findById($this->User->id);

			$this->redirect(Router::url("/",true));

		} else {
			/* Save HTTP status for error dialog on connnect page.*/
			$this->redirect(Router::url("/"));
		}

	}

	/** IFRAME **/
	public function createlist() {

		$user = $this->Session->read('user');
		$this->set('username', $user->screen_name);
		$this->set('userId', $user->id);
		$this->autoLayout = false;
	}

	public function getprogress() {

		$data['message'] = $this->Session->read('progress');
		$data['end'] = $this->Session->read('end');

		$this->setAjaxResponse($data);

	}

	public function checklistusers() {
		$this->TwitterList->checkListUsers();
	}

	// AUXILIAR
	private function clearSessionIfIsNotAuthorizedFromTwitter() {

		if (isset($this->request->query['not_authorized'])) {
			$this->Session->destroy();
		}

	}
}
