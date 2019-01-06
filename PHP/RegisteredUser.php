<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.11
 */

require_once "User.php";

class RegisteredUser implements User {

    private $ID = null;
    private $username = null;
    private $password = null;

    public function __construct($u_name) {
        $query = mysqli_query("SELECT * FROM _users WHERE $u_name = name");

        if ($query->num_rows ){
           $result = $query->fetch_assoc();
           $this->ID = $result['ID'];
           $this->username = $result['name'];
           $this->password = $result['pass_word'];
        } else {
            throw new Exception('Utente inesistente');
        }
    }

    public function isRegistered() {
     return true;
    }

    public function getID() {
     return $this->ID;
    }

    public function isCorrectPassword($insertedPassword) {
        return md5($insertedPassword) == $this->password;
    }

    public function isAdmin() {
        return false;
    }

    public function getInfo() {
        $query = mysqli_query("SELECT * FROM _users WHERE $this->username = name");
        $result = $query->fetch_assoc();

        return $result;
    }

}