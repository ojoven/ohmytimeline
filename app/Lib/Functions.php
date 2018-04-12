<?php
class Functions {

	const URL_FORMAT = '/^(https?):\/\/(([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+(:([a-z0-9$_\.\+!\*\'\(\),;\?&=-]|%[0-9a-f]{2})+)?@)?(?#)((([a-z0-9]\.|[a-z0-9][a-z0-9-]*[a-z0-9]\.)*[a-z][a-z0-9-]*[a-z0-9]|((\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5])\.){3}(\d|[1-9]\d|1\d{2}|2[0-4][0-9]|25[0-5]))(:\d+)?)(((\/+([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)*(\?([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)?)?)?(#([a-z0-9$_\.\+!\*\'\(\),;:@&=-]|%[0-9a-f]{2})*)?$/i';

	/** RESPONSES **/
	public static function buildSuccessResponse() {
		$response = array(
			'success' => true
		);
		return $response;
	}

	/** ARRAYS **/
	public static function setNullsToArrayBlanks($array) {
		foreach ($array as &$element) {
			if (trim($element) == '') {
				$element = null;
			}
		}
		return $array;
	}

	public static function createArrayFromSubLevel($array,$subLevel) {
		$subLevelArray = array();
		foreach ($array as $element) {
			array_push($subLevelArray,$element[$subLevel]);
		}
		return $subLevelArray;
	}

	public static function removeElementByValueFromArray($array,$elementValue) {
		if (($key = array_search($elementValue, $array)) !== false) {
			unset($array[$key]);
		}
		return $array;
	}

	public static function setZeroIfNull($element) {
		if ($element==null) {
			$element = 0;
		}
		return $element;
	}

	public static function searchInArray($array,$query,$field) {
		$results = array();
		foreach ($array as $element) {
			if(strpos(strtolower($element[$field]), strtolower($query)) !== FALSE) {
				array_push($results,$element);
			}
		}

		return $results;
	}

	public static function extractArrayIdsFromArrayObjects($arrayObjects,$index) {
		$arrayIds = array();
		foreach ($arrayObjects as $object) {
			array_push($arrayIds,$object[$index]['id']);
		}
		return $arrayIds;
	}

	public static function removeClassFromQueryResults($results,$className) {
		$resultsParsed = array();
		foreach ($results as $result) {
			$parsedResult = $result[$className];
			$parsedResult['class'] = $className;
			$resultsParsed[] = $parsedResult;
		}
		return $resultsParsed;
	}

	/** STRINGS **/
	public static function explode($delimiter, $string) {
		if (trim($string)=='') {
			return array();
		} elseif (!strpos($string,$delimiter)) {
			return array($string);
		} else {
			return explode($delimiter, $string);
		}
	}

	public static function containsSubstring($string,$substring) {
		$pos = strpos($string,$substring);

		if($pos === false) {
			return false;
		}
		else {
			return true;
		}
	}

	public static function shortString($string,$length) {
		if (strlen($string)>$length) {
			return substr($string,0,$length-3) . '...';
		}
		return $string;
	}

	public static function removeQuotes($string) {
		$string = str_replace("'","",$string);
		$string = str_replace('"','',$string);
		return $string;
	}

	public static function escapeSingleQuotes($string) {
		$string = str_replace("'","\'",$string);
		return $string;
	}

	public static function generateSlug($string) {
		$string = preg_replace("`\[.*\]`U","",$string);
		$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
		$string = htmlentities($string, ENT_COMPAT, 'utf-8');
		$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
		$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);

		$string = str_replace("-amp-","--amp--",$string);
		$string = str_replace("-amp-","-",$string);
		$string = preg_replace('/[-]+/', '-', $string);
		$string = strtolower(trim($string, '-'));

		return $string;
	}

	/** BOOLS **/
	public static function parseBoolToString($bool) {
		if ($bool) {
			return 'true';
		}
		return 'false';
	}

	/** DATETIMES **/
	public static function getNowDatetimeISO8601() {
		$time = time();
		$ISODateTime = date(DATE_ISO8601,$time);
		return $ISODateTime;
	}


	/** CURLS **/
	public static function getUrl($url) {

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		curl_close($curl);

		return $data;

	}

	public static function fileGetContents($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	public static function getImageSizeFast($url) {
		$headers = array(
				"Range: bytes=0-32768"
		);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		curl_close($curl);

		try {
			if (APP_ENV=="development") {
				xdebug_disable();
				Configure::write('debug', 0);
			}
			error_reporting(E_ERROR | E_PARSE);
			$im = imagecreatefromstring($data);
		} catch (Exception $e) {
			// do nothing
			return false;
		}

		$params['width'] = imagesx($im);
		$params['height'] = imagesy($im);
		return $params;
	}

	public static function urlExists($url) {

		$h = get_headers($url);
		$status = array();
		preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0] , $status);
		return ($status[1] == 200);
	}

	public static function isValidUrl($url) {
		if (self::startsWith(strtolower($url), 'http://localhost')) {
			return true;
		}
		return preg_match(self::URL_FORMAT, $url);
	}

	public static function startsWith($haystack, $needle) {
		return $needle === "" || strpos($haystack, $needle) === 0;
	}

	/** IPS **/
	public static function getRealIP() {
		$ipaddress = '';
		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
			$ipaddress =  $_SERVER['HTTP_CF_CONNECTING_IP'];
		} else if (isset($_SERVER['HTTP_X_REAL_IP'])) {
			$ipaddress = $_SERVER['HTTP_X_REAL_IP'];
		}
		else if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}

	/** BROWSER LANGUAGE **/
	public static function getBrowserLanguage() {

		$lang2digits = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		$lang3digits = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 3);
		if ($lang2digits == 'es' || $lang2digits == 'ca' || $lang2digits == 'eu'
		|| $lang3digits == 'ast' || $lang3digits == 'gal') {
			return 'es';
		}

		return 'en';
	}

	/** COUNTRY DETECT **/
	public static function getCountryByIP($ip) {

		$ip = (isset($_GET['ip'])) ? $_GET['ip'] : $ip;
		$s = file_get_contents('http://ip2c.org/'.$ip);
		switch($s[0]) {
			case '1':
				$reply = explode(';', $s);
				return strtolower($reply[1]); // 2 digit code
			case '0':
			case '2':
			default:
				return false;
		}
	}

	public static function isSpanishTalkingCountry() {

		$ip = self::getRealIP();
		$country = self::getCountryByIP($ip);
		$spanishCountries = array(
			'es', 'mx', 'co', 'ar', 'pe', 've', 'cl', 'ec', 'gt', 'cu', 'bo', 'do', 'hn', 'py', 'sv', 'ni', 'cr', 'pr', 'pa', 'uy', 'gq'
		);

		return ($country && in_array($country, $spanishCountries));

	}

	/** VERSIONING / CACHE CLEAR **/
	public static function majestic_get_current_version($type) {

		$allowedTypes = array('css', 'js');
		$pathToVersionsJsonFile = WWW_ROOT . '/versions.json';
		$versionsJson = file_get_contents($pathToVersionsJsonFile);
		$versions = json_decode($versionsJson, true);
		if (in_array($type, $allowedTypes) && isset($versions[$type])) {
			return $versions[$type];
		}

	}

}