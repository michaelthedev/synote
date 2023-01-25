<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 18 Jul, 2022 11:18AM
// +------------------------------------------------------------------------+
// | 2022 Logad Networks
// +------------------------------------------------------------------------+

// +----------------------------+
// | Notes Class
// +----------------------------+

class Notes extends DB {

	## Add note ##
	public static function addNew($data) {
		$response['status'] = false;
		$response['message'] = "Failed to add new note";

		// Validate user id
		$account = Account::validateUserID($data['userID']);
		if (empty($account)) {
			$response['message'] = "Invalid userID";
			return $response;
		}

		$title = $data['title'] ?? null;
		$content_to_wrap = strip_tags(html_entity_decode($data['content']));
		$extract = substr($content_to_wrap, 0, 310);
		// Insert into database
		$insertQuery = DB::RunQuery([
			"query" => "INSERT INTO user_notes (user_id, title, content, extract, date_created) VALUES (?, ?, ?, ?, ?)",
			"values" => [$account->id, $title, $data['content'], $extract, time()],
			"returnConfirmation" => true
		]);
		if ($insertQuery === true) {
			$response['status'] = true;
			$response['message'] = "Note added";
		}
		return $response;
	}

	## Edit Note ##
	public static function editNote($data) {
		$response['status'] = false;
		$response['message'] = "Failed to save changes";

		if (empty($data['title']) && empty($data['content'])) {
			$response['message'] = "Your note needs to have a title or content";
			return $response;
		}

		// Validate user id
		$account = Account::validateUserID($data['userID']);
		if (empty($account)) {
			$response['message'] = "Invalid userID";
			return $response;
		}

		$ex = explode('_', str_replace('NT', '', $data['noteID']));
		$noteid = $ex[1] ?? null;
		$note = self::single($noteid);
		// Check if note is on the DB
		if (empty($note)) {
			$response['message'] = "Invalid note id";
			return $response;
		}

		// Block edit if note user id doesn't match the account id
		if ($note->user_id !== $account->id) {
			$response['message'] = "You can't edit this note";
			return $response;
		}
		
		$title = $data['title'] ?? null;
		$content_to_wrap = strip_tags(html_entity_decode($data['content']));
		$extract = substr($content_to_wrap, 0, 310);
		// Update
		$updateQuery = DB::RunQuery([
			"query" => "UPDATE user_notes SET title = ?, content = ?, extract = ?, date_modified = ? WHERE id = ?",
			"values" => [$title, $data['content'], $extract, time(), $note->id],
			"returnConfirmation" => true
		]);
		if ($updateQuery === true) {
			$response['status'] = true;
			$response['message'] = "Note saved";
		}

		return $response;
	}

	## Delete Note ##
	public static function deleteNote($data) {
		$response['status'] = false;
		$response['message'] = "Failed to delete note";

		// Validate user id
		$account = Account::validateUserID($data['userID']);
		if (empty($account)) {
			$response['message'] = "Invalid userID";
			return $response;
		}

		$ex = explode('_', str_replace('NT', '', $data['noteID']));
		$noteid = $ex[1] ?? null;
		$note = self::single($noteid);
		// Check if note is on the DB
		if (empty($note)) {
			$response['message'] = "Invalid note id";
			return $response;
		}

		// Block edit if note user id doesn't match the account id
		if ($note->user_id !== $account->id) {
			$response['message'] = "You can't delete this note";
			return $response;
		}

		// delete
		$deleteQuery = DB::RunQuery([
			"query" => "DELETE FROM user_notes WHERE id = ?",
			"values" => [$note->id],
			"returnConfirmation" => true
		]);
		if ($deleteQuery === true) {
			$response['status'] = true;
			$response['message'] = "Note deleted";
		}

		return $response;
	}

	## user notes ##
	public static function byUser($user_id) {
		$limit = 30;
		$notes = DB::RunQuery([
			"query" => "SELECT id, user_id, title, content, extract, DATE(FROM_UNIXTIME(date_created)) as date_created, DATE(FROM_UNIXTIME(date_modified)) as date_modified FROM user_notes WHERE user_id = ? ORDER BY id DESC LIMIT $limit",
			"values" => [$user_id]
		]);
		foreach ($notes as $note) {
			$note->id = "NT".$note->user_id."_".$note->id;
			$note->content = html_entity_decode($note->content);
		}
		return $notes;
	}

	## Single note ##
	private static function single($noteid) {
		return DB::RunQuery([
			"query" => "SELECT * FROM user_notes WHERE id = ?",
			"values" => [$noteid],
			"singleRecord" => true
		]);
	}
}