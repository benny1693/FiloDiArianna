<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 05/02/19
 * Time: 13.08
 */

require_once 'utilities.php';
init();
session_destroy();

header('Location: '.$_SERVER['HTTP_REFERER']);
?>