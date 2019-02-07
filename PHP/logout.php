<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 05/02/19
 * Time: 13.08
 */

require_once 'utilities.php';
session_start();
session_destroy();

if ($_SERVER['HTTP_REFERER'] != 'http://'.$_SERVER['HTTP_HOST'].'/FiloDiArianna/PHP/areapersonale.php')
	header('Location: '.$_SERVER['HTTP_REFERER']);
else
	header('Location: '.'../index.php');
?>