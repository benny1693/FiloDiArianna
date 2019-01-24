<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.16
 */

require_once "RegisteredUser.php";

class Admin extends RegisteredUser {

	public function __construct($u_name){
		parent::__construct($u_name);
	}

	public function isAdmin() {
		return true;
	}

	public function deleteUser($userID) {
		//TODO
	}

	public function approveArticle($articleID) {
		//TODO
	}

	public function deleteArticle($articleID){
		//TODO
	}
}