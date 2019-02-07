<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 06/02/19
 * Time: 11.17
 */

require_once 'Admin.php';
require_once 'UnregisteredUser.php';
require_once 'RegisteredUser.php';

function getLoggedUser($username){
	try {
		return new Admin($username);
	} catch (Exception $exc) {
		try {
			return new RegisteredUser($username);
		} catch (Exception $exc) {
			return new UnregisteredUser();
		}
	}
}

function login($username,$password) {
	$u = getLoggedUser($username);

	if (!$u->isRegistered() || $u->isCorrectPassword($password))
		$u->setSessionVars();

	return $u;
}

function isNamefile($name){
	return $_SERVER['SCRIPT_NAME'] == "/FiloDiArianna/" . $name;
}

function init() {
	session_start();
	$u = getLoggedUser($_SESSION['username']);
	$u->setSessionVars();
	return $u;
}

function addPoints(){
	if (!isNamefile('index.php'))
			return "../";
	return "";
}

function printLinkRicerca($category,$substring,$subcategory,$page,$text) {
	echo '
					<li class="page-item"><a href="ricerca.php?category=' . $category . '&substringSearched=' . $substring . '&subcategory=' . $subcategory . '&page=' . $page . '" class="page-link">' . $text . '</a></li>';
}

function printNavigation($page,$pages){
	echo '
			<nav aria-label="Paginazione" class="nav-pages">
                <ul class="pagination">';
	if ($page == 1)
		echo '
   				<li class="page-item disabled"><a href="#">&laquo;</a></li>
					<li class="page-item disabled"><a href="#">&lsaquo;</a></li>';
	else {
		printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],1, '&laquo;');
		printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],$page - 1 , '&lsaquo;');
	}
	for ($i = 0; $i < 5; $i++) {
		if ($page - 2 + $i > 0 && $page - 2 + $i <= $pages) {
			if ($i == 2)
				echo '<li class="page-item disabled"><a href="#">'.$page.'</a></li>';
			else
				printLinkRicerca($_GET['category'], $_GET['substringSearched'], $_GET['subcategory'], $page + $i - 2, $page + $i - 2);
		}
	}
	if ($page == $pages)
		echo'
          <li class="page-item disabled"><a href="#" >&rsaquo;</a></li>
					<li class="page-item disabled"><a href="#" >&raquo;</a></li>
					';
	else{
		printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],$page + 1, '&rsaquo;');
		printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],$page , '&raquo;');
	}
	echo '
                </ul>
            </nav>
            <ul class="query">';
}

function printInvalidFeedback($message){
	echo "
				<div class=\"invalid-feedback\">
					<p>$message</p>
				</div>";
}


/*
function isNamefile($name){
	return $_SERVER['SCRIPT_URL'] == "/bcosenti/" . $name;
}
*/
