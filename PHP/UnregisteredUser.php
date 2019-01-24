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
		$_SESSION['ID'] = -1;
	}

	public function isRegistered() {
		return false;
	}

	public function subscribe($name,$surname,$gender,$birthDate,
														$email,$username,$password){
		//TODO
	}

	public function login($username,$password) {
		//TODO
	}
}