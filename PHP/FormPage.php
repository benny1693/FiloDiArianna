<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 11/02/19
 * Time: 20.26
 */

require_once 'Page.php';
require_once 'RegisteredUser.php';
require_once 'UnregisteredUser.php';

class FormPage extends Page{

	public $errors = null;

	public function __construct($errors = null){
		$this->errors = $errors;
	}

	public function setErrors($errors) { $this->errors = $errors; }

	public function hasErrors() {
		if ($this->errors == null) return false;

		if (!is_array($this->errors)) return !empty($this->errors);

		$hasError = false;
		foreach ($this->errors as $error)
			$hasError = $hasError || !empty($error);

		return $hasError;
	}

	public function addError($error) {
		if (!is_array($this->errors)) {
			$this->errors = $error;
		} else {
			if (!is_array($error)){
				array_push($this->errors,$error);
			} else {
				$this->errors = array_merge($this->errors,$error);
			}
		}
	}

	function printSelect($list) {
		foreach ($list as $article){
			echo '<option value="'.$article['ID'].'">'.$article['title'].'</option>';
		}
	}

	function selectRefill($post, $category){
		return ($post == $category ? 'selected="selected"' : "");
	}

	function dayTimestamp($milliseconds){
		return floor($milliseconds/86400);
	}

	function isValidDate($date) {
		$date = DateTime::createFromFormat('Y-m-d',$date); // se la data non è valida genera un DateTime('now');
		$today = DateTime::createFromFormat('Ymd',date('Ymd')); // genero un DateTime('now')

		return $this->dayTimestamp($date->getTimestamp()) != $this->dayTimestamp($today->getTimestamp());
	}

	public function inferRegistrationErrors($post, UnregisteredUser $user) {
		$this->errors['name'] = !preg_match("/^([a-zA-Z]){1,20}$/", $post['name']);

		$this->errors['surname'] = !preg_match("/^[a-zA-Z' ]{1,20}$/", $post['surname']);

		$this->errors['email'] = !filter_var($post['email'], FILTER_VALIDATE_EMAIL);

		if ($post['birthdate'] > date('Y-m-d') - 6)
			$this->errors['birthdate'] = "Sei un po' giovane non credi?";
		elseif ($post['birthdate'] <= date('Y-m-d',mktime(0,0,0,2,21,1875)))
			$this->errors['birthdate'] = "Sei davvero nato prima della persona pi&ugrave; anziana del mondo?";
		elseif (!$this->isValidDate($post['birthdate']))
			$this->errors['birthdate'] = "Data non valida";

		if (!preg_match("/^[a-zA-Z0-9]+$/", $post['username']))
			$this->errors['username'] = 'Username non valido';

		$this->errors['password'] = !preg_match("/^([a-zA-Z0-9!@#$%^&*]){6,12}$/", $post['password']);

		$this->errors['confirmpass'] = $post['password'] != $post['confirmpass'];

		if (!$this->hasErrors()) {
				$subscribed = $user->subscribe($post['name'], $post['surname'], $post['gender'], $post['birthdate'],
					$post['email'], $post['username'], $post['password']);

				if (!$subscribed)
					$this->errors['username'] = 'Username gi&agrave; esistente';
		}
	}

	function findCorrectTypes($type) {
		$types = array();
		switch (substr($type,0,1)):
			case 'p':
				$types[0] = 'personaggi';
				break;
			case 'e':
				$types[0] = 'eventi';
				break;
			case 'l':
				$types[0] = 'luoghi';
				break;
		endswitch;

		if ($types[0] == 'eventi'){
			$types[1] = str_replace('_','',$type);
		} else {
			$types[1] = substr($type,2);
		}
		return $types;
	}

	public function adjustFile($files,$info = null) {
		$img = $ext = null;
		if (!empty($files)) {
			$img = file_get_contents($files['image']['tmp_name']);
			$path = $files['image']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
		} else {
			if ($info){
				$img = $info['img'];
				$ext = $info['ext'];
			}
		}

		return array('img' => $img, 'ext' => $ext);
	}

	public function filterRelatedPages($newRelatedID,$oldRelatedPages){
		$filter = array_diff(array_unique($newRelatedID), array('none'));

		$relPagesID = array();
		foreach ($oldRelatedPages as $pageInfo)
			array_push($relPagesID,$pageInfo['ID']);

		return array_values(array_diff($filter,$relPagesID));
	}
}