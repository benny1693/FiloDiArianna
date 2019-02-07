<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.11
 */

require_once "User.php";

class UnregisteredUser extends User{

	public function __construct() {
		parent::__construct();
	}

	public function isRegistered() {
		return false;
	}

	public function subscribe($name,$surname,$gender,$birthDate,$email,$username,$password){

		$birthDate = str_replace(array("-",":"," "),"",$birthDate);
		$this->getDBConnection()->query(
			"CALL insertUser('$username','".addslashes($name)."','".addslashes($surname)."','$birthDate','$gender','$email','$password',0)");

		return $this->getDBConnection()->getError() == 0;
	}

	public function setSessionVars() {
		$_SESSION['ID'] = -1;
	}
}