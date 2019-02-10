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
		$query = $this->getDBConnection()->query("SELECT is_admin FROM Prova._users WHERE ID = $ID");
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
								FROM Prova._modifiedPages
								WHERE ID = $articleID";

		if ($timestamp != null) {
			$timestamp = str_replace(array("-"," ",":"),"",$timestamp);
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
		$timestamp = str_replace(array("-"," ",":"),"",$timestamp);

		$query = $this->getDBConnection()->query(
			"SELECT * FROM Prova.`_modifiedPages` WHERE ID = $articleID AND modTime = $timestamp"
		);

		if ($query->num_rows > 0)
			$this->getDBConnection()->query("CALL declineModification($articleID,$timestamp)");
		else
			$this->deleteArticle($articleID);
	}


	public function deleteArticle($articleID){
		$this->getDBConnection()->query("CALL deletePage($articleID)");
	}

	public function printUserList($userList) {
		foreach ($userList as $row) {

			echo
				"
				<li class=\"page-administration clearfix\">
					<form action=\"gestioneutenti.php\" method=\"post\">
						<input type=\"hidden\" name=\"userID\" value=\"".$row['ID']."\"/>
						<a class=\"pagina\" href=\"profilopubblico.php?userID=".$row['ID']."\">".$row['username']."</a>";

			if ($row['is_admin'] == 0)
				echo "
						<div class=\"bottoni\">
							<button type=\"submit\" class=\"btn btn-outline-primary\">Elimina</button>
						</div>";

			echo "
					</form>
				</li>";
		}
	}

	public function findUser($username) {
		$query = $this->getDBConnection()->query(
			"SELECT * FROM Prova._users WHERE username LIKE '%".addslashes($username)."%'"
		);

		return $query->fetch_all(MYSQLI_ASSOC);
	}
}