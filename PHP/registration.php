<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 07/02/19
 * Time: 0.30
 */

include_once 'utilities.php';
$user = init();
print_r($_POST);
$sub = false;

// TODO: implementare i controlli per la registrazione
unset($_SESSION['registration_errors']);
if (!preg_match("/^([a-zA-Z]){1,20}$/",$_POST['name']))
	$_SESSION['registration_errors']['name'] = true;

if (!preg_match("/^[a-zA-Z' ]{1,20}$/",$_POST['surname']))
	$_SESSION['registration_errors']['surname'] = true;

if (filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) != $_POST['email'])
	$_SESSION['registration_errors']['email'] = true;

if ($_POST['birthdate'] > date('Y-m-d') - 6)
	$_SESSION['registration_errors']['birthdate'] = true;

if (!preg_match("/^[a-zA-Z0-9]+$/",$_POST['username']))
	$_SESSION['registration_errors']['username'] = true;

if (!preg_match("/^([a-zA-Z0-9!@#$%^&*]){6,12}$/",$_POST['password']) || $_POST['password'] != $_POST['confirmpass'])
	$_SESSION['registration_errors']['password'] = true;

if (!isset($_SESSION['registration_errors'])) {
	if ($_POST['password'] == $_POST['confirmpass'])
		echo $sub = $user->subscribe($_POST['name'], $_POST['surname'], $_POST['gender'], $_POST['birthdate'],
			$_POST['email'], $_POST['username'], $_POST['password']);

	session_destroy();
	$user = init();
	$user = login($_POST['username'], $_POST['password']);
	//header('Location: ../index.php');
}
?>