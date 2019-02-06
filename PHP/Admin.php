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
		if (!$this->isAdmin())
			throw new Exception("Utente non amministratore");
	}

	private function isAdmin() {
		$ID = $this->getID();
		$query = $this->getDBConnection()->query("SELECT is_admin FROM Prova._users WHERE ID = $ID");
		$result = $query->fetch_row()[0];

		return $result == 1;
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

		if ($query->num_rows >= 1)
			if ($timestamp != null)
				$this->getDBConnection()->query("CALL approveModification($articleID,'$timestamp')");
		else
			echo "CALL setPostStatus($articleID,1)";
			$this->getDBConnection()->query("CALL setPostStatus($articleID,1)");
	}

	public function deleteArticle($articleID){
		$this->getDBConnection()->query("CALL deletePage($articleID)");
	}

	public function printUserList($userList) {

		foreach ($userList as $row) {
			$username = $row['username'];
			print_r(
				"
				<li class=\"page-administration clearfix\">
					<form action=\"/ROBE.PHP\" method=\"get\">
						<a class=\"pagina\" href=\"pagina.html\">$username</a>
						<div class=\"bottoni\">
							<button type=\"submit\" class=\"btn btn-outline-primary\">Elimina</button>
						</div>
					</form>
				</li>");
		}
	}

	public function findUser($username) {
		$query = $this->getDBConnection()->query(
			"SELECT * FROM Prova._users WHERE username LIKE '%".addslashes($username)."%'"
		);

		return $query->fetch_all(MYSQLI_ASSOC);
	}
}