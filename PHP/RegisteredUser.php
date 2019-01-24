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
		$query = $this->getDBConnection()->query("SELECT * FROM _users WHERE username = '$u_name'");

		if ($query->num_rows > 0) {
			$result = $query->fetch_all(MYSQLI_ASSOC);
			$this->ID = $result['ID'];
			$this->username = $u_name;
			$this->password = $result['pass_word'];
			$_SESSION['ID'] = $this->ID;
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

	public function isAdmin() {
		return false;
	}

	public function getUsername() {
		return $this->username;
	}

	public function logout() {
		$this->getDBConnection()->disconnect();
	}

	public function insertArticle($title,$content,$image,$authorID,$types,$relatedPages) {
		//TODO
	}

	public function modifyArticle($newtitle,$newcontent,$newimage,$newtypes,$newrelatedPages) {
		//TODO
	}

	public function deleteArticle($articleID){
		//TODO
	}

	public function insertComment($articleID,$content) {
		//TODO
	}
}