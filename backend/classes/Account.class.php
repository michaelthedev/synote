<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 28 Jul, 2022 07:52AM
// +------------------------------------------------------------------------+
// | 2022 Logad Networks
// +------------------------------------------------------------------------+

// +----------------------------+
// | Account Class
// +----------------------------+

class Account extends DB {
	private static $allowedColumns = "id, username, user_token, date";

	public static function getByToken($user_token) {
		return DB::RunQuery([
			"query" => "SELECT ".self::$allowedColumns." FROM users WHERE user_token = ?",
			"values" => [$user_token],
			"singleRecord" => true
		]);
	}

	public static function getByID($user_id) {
		return DB::RunQuery([
			"query" => "SELECT ".self::$allowedColumns." FROM users WHERE id = ?",
			"values" => [$user_id],
			"singleRecord" => true
		]);
	}

	public static function validateUserID($userID) {
		self::$allowedColumns = "id";
		return self::getByToken(App::decrypt($userID));
	}
}