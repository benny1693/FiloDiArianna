<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.09
 */

class DatabaseConnection{

	private $host = "localhost";
	private $username = "user";
	private $password = "1111";
	private $connectionMYSQL;

	public function __construct(){
		if (!$this->connectToDatabase('Prova'))
			throw new Exception();
	}

	public function DatabaseConnection($host,$username,$password,$connection) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		if (!$this->connectToDatabase('Prova'))
			throw new Exception();
	}

	public function connectToDatabase($database) {
		$this->connectionMYSQL = mysqli_connect($this->host,$this->username,$this->password,$database);
		if (!$this->connectionMYSQL)
			return false;
		else
			return true;
	}

	public function disconnect() {
		if (!$this->connectionMYSQL)
			$this->connectionMYSQL->close();
	}

	public function getConnection() {
		return $this->connectionMYSQL;
	}

	public function getError() {
		return $this->connectionMYSQL->errno;
	}

	public function getErrorMessage() {
		return $this->connectionMYSQL->error;
	}

	public function affectedRows() {
		return $this->connectionMYSQL->affected_rows;
	}

	public function query($query) {
		return mysqli_query($this->connectionMYSQL,$query);
	}

}