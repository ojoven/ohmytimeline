<?php
App::import('Vendor', 'twitterOAuth', array('file' => 'twitterOauth' . DS . 'twitteroauth.php'));
App::uses('Functions', 'Lib');

class TwitterList extends AppModel {

	// const NUM_TRIES_COMPLETE = 4;
	// When this project was first done there seemed to be a problem with Twitter API
	// that didn't add all the users to a list so we had to do some additional tries.
	// Twitter API seems to be working OK now so no additional tries, just one.
	const NUM_TRIES_COMPLETE = 1;
	const NUM_TRIES_QUICK = 1;

	public $numTries;
	public $totalSteps = 20;
	public $credentials;
	public $step;

	const NUM_MAX_USERS_LIST = 5000;

	/** CREATE LIST **/
	public function createList() {

		$testFrontend = false;
		if ($testFrontend) {
			$this->testFrontend();
			return false;
		}

		try {

			// Get user params
			$user = $this->getUserFromSession();
			$userId = $user->id;
			$username = $user->screen_name;

			// Get connection to Twitter API
			$connection = $this->getConnection($userId, true);

			// Follow author
			$this->followAuthorIfUserSelectedOption($connection);

			// Get Following users' IDs
			$followingIds = $this->getFollowingUserIds($connection, $username, $userId);

			// Let's create the list
			$list = $this->createListOnTwitter($connection);

			// Let's save the list on DB
			$this->saveListOnDB($user, $list);

			// Let's add the users to the list
			$this->addUsersToListOnTwitter($connection, $list, $followingIds);

			// Finish!
			$data = array('url' => "/list/" . $list->user->screen_name . "/" . $list->slug);
			$this->setUpdateProgress($this->totalSteps, __("Success!"), 'success', $data);

		} catch (Exception $e) {

			$this->setProgressError($e->getMessage());
			return false;
		}

	}

	private function testFrontend() {

		$this->setUpdateProgress(1, "Test 1");
		sleep(1);
		$this->setUpdateProgress(2, "Test 2");
		sleep(1);
		$this->setUpdateProgress(3.5, "Test 3");
		sleep(1);
		$this->setUpdateProgress(5.8, "Test 4");
		sleep(1);
		$data = array(
			'url' => '/',
		);
		$this->setUpdateProgress($this->totalSteps, __("Success!"), 'success', $data);
		return false;

	}

	private function getUserFromSession() {
		
		$user = CakeSession::read('user');
		if (!$user) throw new Exception(__("There was a problem with getting the user from the session. Please reload the page."));
		return $user;
	}

	private function followAuthorIfUserSelectedOption($connection) {

		$follow = CakeSession::read('follow');
		if ($follow) {
			$screenName = 'lindydeveloper'; // TODO: retrieve the user by language
			$params = array(
				'screen_name' => $screenName,
				'follow' => false
			);
			$result = $connection->post('friendships/create', $params);

			if (isset($result->errors)) {
				// Do nothing, we won't throw an Exception and stop the process because of this
			}
		}

	}

	private function getFollowingUserIds($connection, $username, $userId) {

		$username = str_replace("@", "", $username);
		$this->setUpdateProgress(3, __("Retrieving users..."));
		$query = $connection->get('friends/ids', array('screen_name' => $username));
		if (!isset($query->errors)) {

			$followingIds = $query->ids;
			array_slice($followingIds, 0, self::NUM_MAX_USERS_LIST); // Max users
			array_push($followingIds, $userId); // We add the proper user to the list
		} else {
			throw new Exception(__("We couldn't retrieve following user ids."));
		}

		return $followingIds;
	}

	private function createListOnTwitter($connection) {

		$publicList = false;

		$params['name'] = __("Oh My Timeline!");
		$params['description'] = "No ads, no algorithms, just my clean TL - Create yours at https://ohmytimeline.com";
		$params['mode'] = ($publicList) ? "public" : "private";
		$this->setUpdateProgress(4, __("Creating list..."));
		$list = $connection->post('lists/create', $params);

		$this->handlePossibleErrorsWhenCreatingListOnTwitter($list);

		return $list;
	}

	private function handlePossibleErrorsWhenCreatingListOnTwitter($list) {

		if (!isset($list->id)) {
			if (isset($list->errors[0]->code) && $list->errors[0]->code == 131) {
				throw new Exception(__("Mmmm, error! Maybe too many lists?: ") . $list->errors[0]['message'] . __(". Please wait some minutes."));
			} else {
				throw new Exception(__("There was a problem creating the list: ") . $list->errors[0]['message']);
			}
		}
	}

	private function saveListOnDB($user, $list) {

		$this->User = ClassRegistry::init('User');
		$userDB = $this->User->findByUserId($user->id);

		$data = array(
			'omt_list_id' => $list->id,
			'omt_list_slug' => $list->slug,
		);

		$this->User->id = $userDB['User']['id'];
		$this->User->save($data);

	}

	private function addUsersToListOnTwitter($connection, $list, $followingIds) {

		$followingIdsChunked = array_chunk($followingIds, 100);
		$params = array();

		$counterChunks = count($followingIdsChunked);

		$this->step = 5;
		$this->totalSteps = $this->step + $counterChunks;

		foreach ($followingIdsChunked as $index => $chunk) {

			$this->setUpdateProgress($this->step + ($index / $counterChunks), __("Adding users to list...(please wait)"));

			shuffle($chunk);

			$params['list_id'] = $list->id;
			$params['user_id'] = implode(",", $chunk);
			$result = $connection->post('lists/members/create_all', $params);

			// TODO: Handle possible errors here

		}

	}

	/** CONNECTION TWITTER **/
	public function getConnection($userId = false, $output = false) {

		if ($output) $this->setUpdateProgress(1, __("Connecting to Twitter..."));
		$accessToken = CakeSession::read('access_token');
		if (!$accessToken && $userId) {
			$this->User = ClassRegistry::init('User');
			$user = $this->User->findByUserId($userId);
			if ($user) {
				$accessToken['oauth_token'] = $user['User']['oauth_token'];
				$accessToken['oauth_token_secret'] = $user['User']['oauth_token_secret'];
				CakeSession::write('access_token', $accessToken);
				CakeSession::write('user', $user);
			}
		}

		if ($accessToken) {
			$connection = new TwitterOAuth(Configure::read('Twitter.consumerKey'), Configure::read('Twitter.consumerSecret'), $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
			$isAuthenticated = $this->_isAuthenticated($connection, $output);
			if ($isAuthenticated) {
				return $connection;
			}
		}

		// If the connection was not correctly done, throw exception
		if ($output) {
			throw new Exception(__("There was a problem connecting to Twitter."));
		}
	}

	public function getTmpConnection() {
		$connection = new TwitterOAuth(Configure::read('Twitter.consumerKey'), Configure::read('Twitter.consumerSecret'));
		return $connection;
	}

	public function getOauthConnection($params) {
		$connection = new TwitterOAuth(Configure::read('Twitter.consumerKey'), Configure::read('Twitter.consumerSecret'), $params['oauth_token'], $params['oauth_token_secret']);
		return $connection;
	}

	private function _isAuthenticated($connection, $output = false) {
		if ($output) $this->setUpdateProgress(2, __("Verifying credentials..."));
		$user = CakeSession::read('user');
		if (!$user) {
			$user = $connection->get('account/verify_credentials');
			if (!$user) {
				return false;
			}
			CakeSession::write('user', $user);
		}
		return true;
	}

	/** FLUSH **/
	public function startProgress() {

		ob_start();
		set_time_limit(0);

		@apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 0);
		@ini_set('implicit_flush', 1);
		for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
		ob_implicit_flush(1);

	}

	private function setProgressError($message) {
		$this->setUpdateProgress(0, $message, 'error');
	}

	private function setUpdateProgress($partial, $message, $type = "progress", $data = null) {
		echo "update progress " . $partial;
		echo "<script>update_progress(" . $partial . "," . $this->totalSteps . ",'" . $message . "','" . $type . "','" . json_encode($data) . "')</script>" .str_repeat(' ', 1000);
		//echo "<script>console.log(1)</script>";
		ob_flush();
		flush();
	}

	/** GET LISTS **/
	public function getListsUser($user) {

		$connection = $this->getConnection($user->id, false);
		$query = $connection->get('lists/ownerships', array('count' => 1000, 'user_id' => $user->id));
		$lists = isset($query->lists) ? $query->lists : array();
		return $lists;

	}

	/** PLAYGROUND **/
	public function checkListUsers() {

		// We're using this user's list because of the high amount of following users she has
		$username = 'lainde';
		$slugList = 'whoinfluences-lainde';

		$userId = Configure::read('Twitter.defaultUserId');

		$connection = $this->getConnection($userId, true);

		// Get list members
		$query = $connection->get('lists/members', array('slug' => $slugList, 'owner_screen_name' => 'ojoven', 'count' => 5000, 'include_entities' => false, 'skip_status' => true));
		$users = $query->users;
		$memberIds = array();
		foreach ($users as $user) {
			$memberIds[] = $user->id;
		}

		// Get following users
		$query = $connection->get('friends/ids', array('screen_name' => $username));
		$followingIds = $query->ids;

		// To be added
		$toBeAdded = array_diff($followingIds, $memberIds);
		$params['slug'] = $slugList;
		$params['owner_screen_name'] = 'ojoven';
		$params['user_id'] = implode(",", $toBeAdded);
		$result = $connection->post('lists/members/create_all', $params);

		// To be deleted
		$toBeDeleted = array_diff($memberIds, $followingIds);

		$params['slug'] = $slugList;
		$params['owner_screen_name'] = 'ojoven';
		$params['user_id'] = implode(",", $toBeDeleted);
		$result = $connection->post('lists/members/destroy_all', $params);

	}

}