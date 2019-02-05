<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.09
 */

class DatabaseConnection{

	private $host = "localhost";
	private $username = "laura";
	private $password = "1811";
	private $connectionMYSQL = null;

	public function __construct(){
		$this->connectionMYSQL = mysqli_connect($this->host,$this->username,$this->password,"Prova");
	}

	public function DatabaseConnection($host,$username,$password) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
	}

	public function connectToDatabase($database) {
		$this->connectionMYSQL = mysqli_connect($this->host,$this->username,$this->password,$database);
	}

	public function disconnect() {
		if ($this->connectionMYSQL != null)
			$this->connectionMYSQL->close();
	}

	public function getConnection() {
		return $this->connectionMYSQL;
	}

	public function query($query) {
		return mysqli_query($this->connectionMYSQL,$query);
	}

}