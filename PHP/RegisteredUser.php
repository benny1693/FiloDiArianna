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

	public function __construct($u_name) {
		parent::__construct();
		$query = $this->getDBConnection()->query("SELECT * FROM Prova._users WHERE username = '$u_name'");

		if ($query->num_rows > 0) {
			$result = $query->fetch_assoc();
			$this->ID = $result['ID'];
			$this->username = $u_name;
			$this->password = $result['pass_word'];
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
		return md5($insertedPassword) == $this->password;
	}

	public function getUsername() {
		return $this->username;
	}

	public function insertArticle($title,$content,$image,$authorID,$types,$relatedPages) {

		$this->getDBConnection()->query(
			"CALL insertPage('".addslashes($title)."','".addslashes($content)."','$image',$authorID,'$types[0]','$types[1]')"
		);

		$query = $this->getDBConnection()->query(
			"SELECT ID,insTime FROM Prova._pages WHERE title = '".addslashes($title)."'"
		);

		$result = $query->fetch_assoc();
		$articleID = $result['ID'];
		$timestamp = str_replace(array(":"," ","-"),"", $result['insTime']);

		foreach ($relatedPages as $relation)
			$this->getDBConnection()->query("CALL insertPendantRelationship($articleID,$relation,'$timestamp')");

	}

	public function modifyArticle($articleID,$newcontent,$newimage,$newtypes,$newrelatedPages) {
		$this->getDBConnection()->query(
			"CALL insertModification($articleID,'".addslashes($newcontent)."','$newimage','$newtypes[0]','$newtypes[1]')");

		$query = $this->getDBConnection()->query("SELECT modTime 
																										FROM Prova._modifiedPages 
																										WHERE ID = $articleID AND content = '".addslashes($newcontent)."'");

		$result = $query->fetch_assoc();
		$timestamp = str_replace(array(":"," ","-"),"", $result['insTime']);
		foreach ($newrelatedPages as $relation)
			$this->getDBConnection()->query("CALL insertPendantRelationship($articleID,$relation,'$timestamp')");
	}

	public function deleteArticle($articleID){
		$query = $this->getDBConnection()->query("SELECT author FROM Prova._pages WHERE ID = $articleID");
		$result = $query->fetch_row()[0];

		if ($result == $this->ID)
			$this->getDBConnection()->query("CALL deletePage($articleID)");
	}

	public function insertComment($articleID,$content) {
		$this->getDBConnection()->query("CALL insertComment($articleID,'".addslashes($content)."',$this->ID)");
	}

}