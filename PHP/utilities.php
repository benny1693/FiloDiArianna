<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 06/02/19
 * Time: 11.17
 */

require_once 'Admin.php';
require_once 'UnregisteredUser.php';
require_once 'RegisteredUser.php';
require_once 'ArticlePage.php';
require_once 'SearchPage.php';
require_once 'FormPage.php';

function getLoggedUser($username){
	try {
		return new Admin($username);
	} catch (Exception $exc) {
		try {
			return new RegisteredUser($username);
		} catch (Exception $exc) {
			return new UnregisteredUser();
		}
	}
}

function login($username,$password) {
	$user = getLoggedUser($username);

	if ($user->isRegistered() && !$user->isCorrectPassword($password))
		$user = new UnregisteredUser();

	$user->setSessionVars();
	return $user;
}

function isNamefile($name){
	return $_SERVER['SCRIPT_NAME'] == "/FiloDiArianna/" . $name;
}

function init() {
	session_start();
	$user = getLoggedUser($_SESSION['username']);
	$user->setSessionVars();
	return $user;
}

function addPoints(){
	if (!isNamefile('index.php'))
			return "../";
	return "";
}

/*
function isNamefile($name){
	return $_SERVER['SCRIPT_URL'] == "/bcosenti/" . $name;
}
*/
?>
