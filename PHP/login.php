<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 05/02/19
 * Time: 13.07
 */

require_once 'utilities.php';

$u = login($_POST['username'],$_POST['password']);

if ($_SESSION['ID'] == -1){
	$_SESSION['login_error'] = true;
	header('Location: accesso.php');
	exit();
} else {
	unset($_SESSION['login_error']);
	header('Location: ../index.php');
	exit();
}
?>