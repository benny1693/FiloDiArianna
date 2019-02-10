<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 10/02/19
 * Time: 15.12
 */
require_once 'utilities.php';
$user = init();
$validField = preg_match('/^(.*[a-zA-Z].*\r*\n*)(.*[a-zA-Z]*.*\r*\n*)*$/',$_POST['content']);

if ($user->isRegistered() && $_SESSION['ID'] == $user->getID()){
	if ($validField) {
        $user->insertComment($_POST['articleID'], $_POST['content']);
    }
	else
		$_SESSION['commenterror'] = true;
}
header('Location: discussione.php?articleID='.$_POST['articleID']);
exit();