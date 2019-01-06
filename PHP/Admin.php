<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.16
 */

require_once "RegisteredUser.php";

class Admin extends RegisteredUser {
    public function isAdmin() {
        return true;
    }
}