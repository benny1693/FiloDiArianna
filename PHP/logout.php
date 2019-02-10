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

header('Location: '.'../index.php');
?>