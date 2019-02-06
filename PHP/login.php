<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 05/02/19
 * Time: 13.07
 */

require_once 'utilities.php';
init();
$u = login($_POST['username'],$_POST['password']);

if ($_SESSION['ID'] == -1){
	$_SESSION['login_error'] = true;
	header('Location: accesso.php');
} else {
	$_SESSION['login_error'] = false;
	header('Location: ../index.php');
}
?>