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

if ($_POST['password'] == $_POST['confirmpass'])
	echo $sub = $user->subscribe($_POST['name'],$_POST['surname'],$_POST['gender'],$_POST['birthdate'],
		$_POST['email'],$_POST['username'],$_POST['password']);

session_destroy();
$user = init();
$user = login($_POST['username'],$_POST['password']);
header('Location: ../index.php');
?>