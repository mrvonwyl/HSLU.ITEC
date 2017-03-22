<?php

//url param start

function getParam($param, $alt){
	$value = ((isset($_GET[$param])) ? $_GET[$param] : $alt);
	return $value;
}

function getCookie($cookie, $alt){
	$value = ((isset($_COOKIE[$cookie])) ? $_COOKIE[$cookie] : $alt);
	return $value;
}

function changeParam($param, $value){
	$requestUri = $_SERVER['REQUEST_URI'];
	$oldUri = substr($requestUri, strripos($requestUri, "/") + 1);
	
	preg_match('/' . $param . '=(\w|\d)*/', $oldUri, $matches);
	
	$toRep = $matches[0];
	$repBy = $param . '=' . $value;
	
	$newUri = str_ireplace($toRep, $repBy, $oldUri);
	
	return $newUri;
}

function urlParamEncrypt($params){
	$crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, mhash(MHASH_ADLER32, 'qMec62Vmy25J2Nua'), $params, MCRYPT_MODE_ECB);
	return $crypt;
}

function urlParamDecrypt($crypt){
	$params = explode("&", mcrypt_decrypt(MCRYPT_RIJNDAEL_256, mhash(MHASH_ADLER32, 'qMec62Vmy25J2Nua'), $crypt, MCRYPT_MODE_ECB));
	
	$parArr = array();
	
	foreach($params as $param){
		$keyVal = explode("=", $param);
		$parArr[$keyVal[0]] = $keyVal[1];
	}
	
	return $parArr;
}

//url param start



//secure login start

function startSecureSession(){
	$session_name = 'sec_session_id'; // Set a custom session name
	$secure = false; // Set to true if using https.
	$httponly = true; // This stops javascript being able to access the session id. 

	ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
	$cookieParams = session_get_cookie_params(); // Gets current cookies params.
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
	session_name($session_name); // Sets the session name to the one set above.
	session_start(); // Start the php session
	session_regenerate_id(true); // regenerated the session, delete the old one.     
}

function login($username, $password, $mysqli) {
	// Using prepared Statements means that SQL injection is not possible.
	
	if ($stmt = $mysqli->prepare("SELECT idUser, username, password, salt FROM t_sec_user WHERE username = ? LIMIT 1")) { 
		$stmt->bind_param('s', $username); // Bind "$email" to parameter.
		$stmt->execute(); // Execute the prepared query.
		$stmt->store_result();
		$stmt->bind_result($user_id, $db_username, $db_password, $salt); // get variables from result.
		$stmt->fetch();
		$password = hash('sha512', $password.$salt); // hash the password with the unique salt.
	

		if($stmt->num_rows == 1) { // If the user exists
			// We check if the account is locked from too many login attempts
			if(checkBrute($user_id, $mysqli) == true) { 
				// Account is locked
				// Send an email to user saying their account is locked
				return false;
			}
			else {
				if($db_password == $password) { // Check if the password in the database matches the password the user submitted. 
					// Password is correct!
	
					$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
					$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
	
					$user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
					$_SESSION['user_id'] = $user_id; 
					$db_username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $db_username); // XSS protection as we might print this value
					$_SESSION['username'] = $db_username;
					$_SESSION['login_string'] = hash('sha512', $password.$ip_address.$user_browser);
					// Login successful.
					// Delete loginattempts
					//$mysqli->query("DELETE FROM 't_sec_loginattempt' WHERE idUser = $user_id");
					
					return true;    
	         	}
	         	else {
					// Password is not correct
					// We record this attempt in the database
					$now = time();
					$mysqli->query("INSERT INTO t_sec_loginattempt (idUser, time) VALUES ('$user_id', '$now')");
					return false;
	         	}
			}
		}
		else {
			// No user exists. 
			return false;
		}
	}
}

function checkBrute($user_id, $mysqli) {
	// Get timestamp of current time
	$now = time();
	// All login attempts are counted from the past 2 hours. 
	$valid_attempts = $now - (2 * 60 * 60); 

	if ($stmt = $mysqli->prepare("SELECT time FROM t_sec_loginattempt WHERE idUser = ? AND time > '$valid_attempts'")) { 
		$stmt->bind_param('i', $user_id); 
		// Execute the prepared query.
		$stmt->execute();
		$stmt->store_result();
      	// If there has been more than 5 failed logins
		if($stmt->num_rows > 5) {
			return true;
		}
		else {
			return false;
		}
	}
}

function checkLogin($mysqli) {
	// Check if all session variables are set
	if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];
		$ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
		$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

		if ($stmt = $mysqli->prepare("SELECT password FROM t_sec_user WHERE idUser = ? LIMIT 1")) { 
			$stmt->bind_param('i', $user_id); // Bind "$user_id" to parameter.
			$stmt->execute(); // Execute the prepared query.
			$stmt->store_result();
 
			if($stmt->num_rows == 1) { // If the user exists
				$stmt->bind_result($password); // get variables from result.
				$stmt->fetch();
				$login_check = hash('sha512', $password.$ip_address.$user_browser);
				if($login_check == $login_string) {
					// Logged In!!!!
					return true;
				}
				else {
					// Not logged in
					return false;
				}
			}
			else {
				// Not logged in
				return false;
			}
		}
		else {
			// Not logged in
			return false;
		}
	}
	else {
		// Not logged in
		return false;
   }
}

//secure login end


?>