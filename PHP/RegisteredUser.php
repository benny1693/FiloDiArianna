<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.11
 */

require_once "User.php";

class RegisteredUser extends User {

	private $ID = null;
	private $username = null;
	private $password = null;
	private $personalia = array();

	public function __construct($u_name) {
		parent::__construct();
		$query = $this->getDBConnection()->query("SELECT * FROM _users WHERE username = '$u_name'");
		if ($query->num_rows > 0) {
			$result = $query->fetch_assoc();
			$this->ID = $result['ID'];
			$this->username = $u_name;
			$this->password = $result['pass_word'];
			$this->personalia = array(
				"name" => $result['name'],
				"surname" => $result['surname'],
				"birthdate" => $result['birthDate'],
				"email" => $result['email'],
				"gender" => $result['gender']
			);
		} else {
			throw new Exception("Utente non esistente");
		}
	}

	public function isRegistered() {
		return true;
	}

	public function getID() {
		return $this->ID;
	}

	public function isCorrectPassword($insertedPassword) {
		return sha1($insertedPassword) == $this->password;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPersonalia() {
		return $this->personalia;
	}

	public function insertArticle($title,$content,$image,$ext,$authorID,$types,$relatedPages) {

		$this->getDBConnection()->query(
			"CALL insertPage('".addslashes($title)."','".addslashes($content)."','".addslashes($image)."','".$ext."',$authorID,'$types[0]','$types[1]')"
		);

		if ($this->getDBError() == 0) {

			$query = $this->getDBConnection()->query(
				"SELECT ID,insTime FROM _pages WHERE title = '" . addslashes($title) . "'"
			);

			$result = $query->fetch_assoc();
			$articleID = $result['ID'];
			$timestamp = self::DBTimeFormat($result['insTime']);

			foreach ($relatedPages as $relation)
				$this->getDBConnection()->query("CALL insertPendantRelationship($articleID,$relation,'$timestamp')");
		}
	}

	public function modifyArticle($articleID,$newcontent,$newimage,$newext,$newtypes,$newrelatedPages) {
		$this->getDBConnection()->query(
			"CALL insertModification($articleID,'".addslashes($newcontent)."','".addslashes($newimage)."','$newext','$newtypes[0]','$newtypes[1]')");

		$query = $this->getDBConnection()->query("SELECT modTime FROM _modifiedPages WHERE ID = $articleID ORDER BY modTime DESC LIMIT 1");

		$result = $query->fetch_assoc();
		$timestamp = self::DBTimeFormat($result['modTime']);

		foreach ($newrelatedPages as $relation)
			$this->getDBConnection()->query("CALL insertPendantRelationship($articleID,$relation,'$timestamp')");

	}


	public function declinePendant($articleID,$timestamp){
		$query = $this->getDBConnection()->query("SELECT author FROM _pages WHERE ID = $articleID");
		$result = $query->fetch_row()[0];

		if ($result == $this->ID){

			$timestamp = self::DBTimeFormat($timestamp);

			$query = $this->getDBConnection()->query(
				"SELECT * FROM _modifiedPages WHERE ID = $articleID AND modTime = $timestamp"
			);

			if ($query->num_rows > 0)
				$this->getDBConnection()->query("CALL declineModification($articleID,$timestamp)");
			else
				$this->deleteArticle($articleID);
		}
	}


	public function deleteArticle($articleID){
		$query = $this->getDBConnection()->query("SELECT author FROM _pages WHERE ID = $articleID");
		$result = $query->fetch_row()[0];

		if ($result == $this->ID)
			$this->getDBConnection()->query("CALL deletePage($articleID)");
	}

	public function insertComment($articleID,$content) {
		$this->getDBConnection()->query("CALL insertComment($articleID,'".addslashes($content)."',$this->ID)");
	}


	public function setSessionVars() {
		$_SESSION['username'] = $this->getUsername();
		$_SESSION['ID'] = $this->getID();
	}

}