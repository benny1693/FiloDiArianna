<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.11
 */

require_once "User.php";

class UnregisteredUser implements User{

    private $ID = null;

    function __construct() {
        $this->ID = md5(time());
    }

    function getID() {
     return $this->ID;
    }

    function isRegistered() {
        return false;
    }
}