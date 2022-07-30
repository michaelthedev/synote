<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 18 Jul, 2022 11:09AM
// +------------------------------------------------------------------------+
// | 2022 Logad Networks
// +------------------------------------------------------------------------+

// +----------------------------+
// | Auth Class
// +----------------------------+

class Auth extends DB {

	## Scan to login ##
	public static function initScanToLogin($UA): array {
		$response['status'] = false;
		$response['message'] = "An error occurred";

		$sessionID = uniqid('ses_', true);
		$insert = DB::RunQuery([
			"query" => "INSERT INTO login_sessions (UA, session_id, date) VALUES(?, ?, ?)",
			"values" => [$UA, $sessionID, time()],
			"returnConfirmation" =>  true
		]);
		if ($insert === true) {
			$response['status'] = true;
			$response['message'] = "Session created";
			$response['sessionID'] = $sessionID;
		}
		return $response;
	}

	## Connect device ##
	public static function connectDevice($data): array {
		$response['status'] = false;
		$response['message'] = "An error occurred";

		// Validate user id
		$account = Account::validateUserID($data['userID']);
		if (empty($account)) {
			$response['message'] = "Invalid userID";
			return $response;
		}

		if (empty($data['sessionID'])) {
			$response['message'] = "Invalid scan code";
			return $response;
		}


		// Check if session id is valid
		$loginSession = DB::RunQuery([
			"query" => "SELECT * FROM login_sessions WHERE session_id = ?",
			"values" => [$data['sessionID']],
			"singleRecord" => true
		]);
		if (empty($loginSession)) {
			$response['message'] = "Invalid login session id. Please check your code";
			return $response;
		}

		// check if session is expired
		if (time() > strtotime('+5 mins', $loginSession->date) || !empty($loginSession->user_id)) {
			// Delete session
			DB::RunQuery([
				"query" => "DELETE FROM login_sessions WHERE id = ?",
				"values" => [$loginSession->id]
			]);
			$response['message'] = "Login code has expired. Please request a new one";
			return $response;
		}

		$update = DB::RunQuery([
			"query" => "UPDATE login_sessions SET status = 'scanned', user_id = ? WHERE id = ?",
			"values" => [$account->id, $loginSession->id],
			"returnConfirmation" =>  true
		]);
		if ($update === true) {
			$response['status'] = true;
			$response['message'] = "Device connected";
		}
		return $response;
	}

	## Check scan status ##
	public static function checkScanStatus($sessionID): array {
		$response['status'] = false;
		$response['message'] = "No changes detected";

		$loginSession = DB::RunQuery([
			"query" => "SELECT * FROM login_sessions WHERE session_id = ?",
			"values" => [$sessionID],
			"singleRecord" => true
		]);
		if (!empty($loginSession->user_id)) {
			$account = Account::getById($loginSession->user_id);
			$response['status'] = true;
			$response['message'] = "Login successful";
			$response['userID'] = App::encrypt($account->user_token);;
		}
		return $response;
	}

	## User Login ##
	public static function login($username, $password): array {
		$response['status'] = false;
		$response['message'] = "Login failed";

		// Check if user exists
		$user = DB::RunQuery([
			"query" => "SELECT id, password, user_token FROM users WHERE username = ?",
			"values" => [$username],
			"singleRecord" => true
		]);
		if (empty($user)) {
			$response['message'] = "Invalid login credentials";
			return $response;
		}

		// Verify password
		if (!password_verify($password, $user->password)) {
			$response['msg'] = "Invalid login credentials";
			return $response;
		}

		$response['status'] = true;
		$response['message'] = "Login successful";
		$response['userID'] = App::encrypt($user->user_token);
		return $response;
	}

	## User Register ##
	public static function register($data): array {
		$response['status'] = false;
		$response['message'] = "Registration failed";
		$response['userID'] = null;

		$allowed = array('_');
		$blocked_words = ['admin', 'administrator', 'owner', 'manager'];

		// Validate username
		if (!ctype_alnum(str_replace($allowed, '', $data['username']))) {
		    $response['message'] = "Username can only contain alphanumeric characters, periods and underscore";
		    return $response;
		}

		// Blocked words
		if (in_array($data['username'], $blocked_words)) {
			$response['message'] = "Username is blocked";
			return $response;
		}
		$username = strip_tags(str_replace(" ", "_", $data['username']));

		// Check if username already exists
		if (!empty(DB::RunQuery([
			"query" => "SELECT id FROM users WHERE username = ?",
			"values" => [$username],
			"singleRecord" => true
		]))) {
			$response['message'] = "Username is not available";
			return $response;
		}

		$token = bin2hex(random_bytes(12));
		// If you get an error concerning the above, comment the above line and uncomment the next line.
		// $token = bin2hex(openssl_random_pseudo_bytes(12));
		$password = password_hash($data['password'], PASSWORD_DEFAULT);

		$insertQuery = DB::RunQuery([
			"query" => "INSERT INTO users (username, password, user_token, date) VALUES (?, ?, ?, ?)",
			"values" => [$username, $password, $token, time()],
			"returnConfirmation" =>  true
		]);
		if ($insertQuery === true) {
			$response['message'] = "Registration successful";
			$response['status'] = true;
			$response['userID'] = App::encrypt($token);
		}
		
		return $response;
	}
}