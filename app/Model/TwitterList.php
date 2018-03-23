<?php
App::import('Vendor', 'twitterOAuth',array('file'=>'twitterOauth'.DS.'twitteroauth.php'));
App::uses('Functions','Lib');

class TwitterList extends AppModel {

	// const NUM_TRIES_COMPLETE = 4;
	// When this project was first done there seemed to be a problem with Twitter API
	// that didn't add all the users to a list so we had to do some additional tries.
	// Twitter API seems to be working OK now so no additional tries, just one.
	const NUM_TRIES_COMPLETE = 1;
	const NUM_TRIES_QUICK = 1;

	public $numTries;
	public $totalSteps = 0;
	public $credentials;

	const NUM_MAX_USERS_LIST = 5000;

	public function createList($userId,$username) {

		$userId = Configure::read('Twitter.defaultUserId'); // TMP TODO REMOVE FROM HERE
		$username = 'ojoven'; // TMP TODO REMOVE FROM HERE

		$this->_flushManagement();

		if (!$username || trim($username)=="") {
			$this->_setProgressError(__("You must select a valid username."));
			return false;
		}

		$this->numTries = self::NUM_TRIES_COMPLETE;

		$this->totalSteps = $this->numTries + 5;
		$connection = $this->getConnection($userId,true);
		if ($connection) {
			$this->_createList($connection, $username);
		} else {
			$this->_setProgressError(__("There was a problem connecting to Twitter."));
		}

	}

	private function _createList($connection,$username) {

		$publicList = true;

		if (isset($username)) {
			$username = str_replace("@","",$username);
			$this->_setUpdateProgress(3,__("Retrieving users..."));
			$query = $connection->get('friends/ids', array('screen_name' => $username));
			$data['success'] = true;
			if (isset($query->errors)) {
				$data['success'] = false;
				$this->_setProgressError(__("You must select a valid username."));
				return false;
			} else {

				$followingIds = $query->ids;

				// Max users
				array_slice($followingIds, 0, self::NUM_MAX_USERS_LIST);

				// We add the proper user to the list
				$influencer = $connection->get('users/lookup', array('screen_name' => $username));
				$influencer = $influencer[0];
				array_push($followingIds,$influencer->id);

				// Let's create the list
				$usernameWithAt = "@".$username;
				$params['name'] = __("Oh, My Timeline! - ") . $usernameWithAt;
				if (strlen($params['name'])>25) {
					$params['name'] = Functions::shortString(__("OMT! ") . $usernameWithAt, 25);
				}
				$params['description'] = "No ads, no algorithms, just my clean TL - Create yours at https://ohmytimeline.com";
				$params['mode'] = ($publicList) ? "public" : "private";
				$this->_setUpdateProgress(4,__("Creating list..."));
				$list = $connection->post('lists/create', $params);

				// Error creating list?
				if (!isset($list->id)) {
					$data['success'] = false;
					if (isset($list->errors[0]->code) && $list->errors[0]->code==131) {
						$this->_setProgressError(__("Mmmm, error! Maybe too many lists?: ") . $list->errors[0]['message'] . __(". Please wait some minutes."));
					} else {
						$this->_setProgressError(__("There was a problem creating the list: ") . $list->errors[0]['message']);
					}
					return false;
				}

				$listId = $list->id;

				// Let's chunk the array in max accepted ids Twitter API
				$followingIdsChunked = array_chunk($followingIds, 100);
				$params = array();

				$counter = 1;
				$counterChunks = count($followingIdsChunked);
				while ($counter <= $this->numTries) {

					$step = 4 + $counter;

					foreach ($followingIdsChunked as $index=>$chunk) {

						$this->_setUpdateProgress($step + ($index/$counterChunks),__("Adding users to list...(please wait)"));

						shuffle($chunk);

						$params['list_id'] = $listId;
						$params['user_id'] = implode(",",$chunk);
						$result = $connection->post('lists/members/create_all', $params);

					}

					$counter++;
				}

				// Finish!

				$user = CakeSession::read('user');

				$listUrl = "https://twitter.com/".$list->user->screen_name."/lists/".$list->slug;
				$this->_setUpdateProgress($step+1, __("List created! Click here to see it."), 'success', $listUrl);

			}
		}

	}

	/** CONNECTION TWITTER **/
	public function getConnection($userId = false,$output = false) {
		if ($output) $this->_setUpdateProgress(1,__("Connecting to Twitter..."));
		$accessToken = CakeSession::read('access_token');
		if (!$accessToken && $userId) {
			$this->User = ClassRegistry::init('User');
			$user = $this->User->findByUserId($userId);
			if ($user) {
				$accessToken['oauth_token'] = $user['User']['oauth_token'];
				$accessToken['oauth_token_secret'] = $user['User']['oauth_token_secret'];
				CakeSession::write('access_token',$accessToken);
				CakeSession::write('user',$user);
			}
		}
		if ($accessToken) {
			$connection = new TwitterOAuth(Configure::read('Twitter.consumerKey'), Configure::read('Twitter.consumerSecret'), $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
			$isAuthenticated = $this->_isAuthenticated($connection,$output);
			if ($isAuthenticated) {
				return $connection;
			}
		}
		return false;
	}

	public function getTmpConnection() {
		$connection = new TwitterOAuth(Configure::read('Twitter.consumerKey'), Configure::read('Twitter.consumerSecret'));
		return $connection;
	}

	public function getOauthConnection($params) {
		$connection = new TwitterOAuth(Configure::read('Twitter.consumerKey'), Configure::read('Twitter.consumerSecret'), $params['oauth_token'], $params['oauth_token_secret']);
		return $connection;
	}

	private function _isAuthenticated($connection,$output = false) {
		if ($output) $this->_setUpdateProgress(2,__("Verifying credentials..."));
		$user = CakeSession::read('user');
		if (!$user) {
			$user = $connection->get('account/verify_credentials');
			if (isset($verifyCredentials->errors)) {
				return false;
			}
			CakeSession::write('user',$user);
		}
		return true;
	}

	/** FLUSH **/
	private function _flushManagement() {

		ob_start();
		set_time_limit(0);

		@apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 0);
		@ini_set('implicit_flush', 1);
		for ($i = 0; $i < ob_get_level(); $i++) { ob_end_flush(); }
		ob_implicit_flush(1);

	}

	private function _setProgressError($message) {
		$this->_setUpdateProgress(0,$message,'error');
	}

	private function _setUpdateProgress($partial,$message, $type = "progress", $url = null) {
		echo "<script>update_progress(".$partial.",".$this->totalSteps.",'".$message."','".$type."','".$url."')</script>".str_repeat(" ",1000);
		ob_flush();
		flush();
	}

	/** PLAYGROUND **/
	public function checkListUsers() {

		// We're using this user's list because of the high amount of following users she has
		$username = 'lainde';
		$slugList = 'whoinfluences-lainde';

		$userId = Configure::read('Twitter.defaultUserId');

		$connection = $this->getConnection($userId,true);

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
		$params['user_id'] = implode(",",$toBeAdded);
		$result = $connection->post('lists/members/create_all', $params);

		// To be deleted
		$toBeDeleted = array_diff($memberIds, $followingIds);

		$params['slug'] = $slugList;
		$params['owner_screen_name'] = 'ojoven';
		$params['user_id'] = implode(",",$toBeDeleted);
		$result = $connection->post('lists/members/destroy_all', $params);

	}

}