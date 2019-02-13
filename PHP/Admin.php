<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 */

require_once "RegisteredUser.php";

class Admin extends RegisteredUser {

	public function __construct($u_name) {
		parent::__construct($u_name);
		if (!$this->hasAdminPrivilege())
			throw new Exception("Utente non amministratore");
	}

	private function hasAdminPrivilege() {
		$ID = $this->getID();
		$query = $this->getDBConnection()->query("SELECT is_admin FROM _users WHERE ID = $ID");
		$result = $query->fetch_row()[0];

		return $result == 1;
	}

	public function isAdmin() {
		return true;
	}

	public function deleteUser($userID) {
		$this->getDBConnection()->query("CALL deleteUser($userID)");
	}

	public function approveArticle($articleID,$timestamp = null) {

		$select = "SELECT *
								FROM _modifiedPages
								WHERE ID = $articleID";

		if ($timestamp != null) {
			$timestamp = self::DBTimeFormat($timestamp);
			$select = $select . " AND modTime = '$timestamp'";
		}

		$query = $this->getDBConnection()->query($select);

		if ($timestamp != null && $query->num_rows >= 1) {
			$this->getDBConnection()->query("CALL approveModification($articleID,'$timestamp')");
		} else {
			$this->getDBConnection()->query("CALL setPostStatus($articleID,1)");
		}
	}

	public function declinePendant($articleID,$timestamp){
		$timestamp = self::DBTimeFormat($timestamp);

		$query = $this->getDBConnection()->query(
			"SELECT * FROM _modifiedPages WHERE ID = $articleID AND modTime = $timestamp"
		);

		if ($query->num_rows > 0)
			$this->getDBConnection()->query("CALL declineModification($articleID,$timestamp)");
		else
			$this->deleteArticle($articleID);
	}


	public function deleteArticle($articleID){
		$this->getDBConnection()->query("CALL deletePage($articleID)");
	}

	public function findUser($username) {
		$query = $this->getDBConnection()->query(
			"SELECT * FROM _users WHERE username LIKE '%".addslashes($username)."%'"
		);

		return $query->fetch_all(MYSQLI_ASSOC);
	}
}