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
require_once 'ArticlePage.php';

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

function printLinkUser($page,$text) {
	echo '
					<li class="page-item"><a href="gestioneutenti.php?page='.$page.'" class="page-link">'.$text.'</a></li>';
}

function printNavigation($page,$pages,$article = true){
	echo '
			<nav aria-label="Paginazione" class="nav-pages">
                <ul class="pagination">';
	if ($page == 1)
		echo '<li class="page-item disabled"><a href="#">&laquo;</a></li>
					<li class="page-item disabled"><a href="#">&lsaquo;</a></li>';
	else {
		if ($article){
			printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],1, '&laquo;');
			printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],$page - 1 , '&lsaquo;');
		} else {
			printLinkUser(1,'&laquo;');
			printLinkUser($page-1,'&lsaquo;');
		}
	}
	for ($i = 0; $i < 5; $i++) {
		if ($page - 2 + $i > 0 && $page - 2 + $i <= $pages) {
			if ($i == 2)
				echo '
					<li class="page-item disabled"><a href="#">'.$page.'</a></li>';
			else {
				if ($article)
					printLinkRicerca($_GET['category'], $_GET['substringSearched'], $_GET['subcategory'], $page + $i - 2, $page + $i - 2);
				else
					printLinkUser($page + $i - 2,$page + $i -2);
			}
		}
	}
	if ($page == $pages)
		echo'
 					<li class="page-item disabled"><a href="#" >&rsaquo;</a></li>
					<li class="page-item disabled"><a href="#" >&raquo;</a></li>
					';
	else{
		if ($article){
			printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],$page + 1, '&rsaquo;');
			printLinkRicerca($_GET['category'],$_GET['substringSearched'],$_GET['subcategory'],$pages , '&raquo;');
		} else {
			printLinkUser($page + 1, '&rsaquo;');
			printLinkUser($pages , '&raquo;');
		}
	}
	echo '
                </ul>
            </nav>';
}

function printFeedback($message,$valid){
	if ($valid)
		echo "
				<div class=\"feedback valid-feedback\">";
	else
		echo "
				<div class=\"feedback invalid-feedback\">";

	echo "
					<p>$message</p>
				</div>";
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

function printSelect($list) {
	foreach ($list as $article){
		echo '
                            <option value="'.$article['ID'].'">'.$article['title'].'</option>';
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

	return dayTimestamp($date->getTimestamp()) != dayTimestamp($today->getTimestamp());
}
/*
function isNamefile($name){
	return $_SERVER['SCRIPT_URL'] == "/bcosenti/" . $name;
}
*/
?>
