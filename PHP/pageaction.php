<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 07/02/19
 * Time: 22.21
 */
require_once 'utilities.php';
$u = init();

switch($_POST['action']):
	case 'Accetta':
		$u->approveArticle($_POST['pageid'],str_replace(array(':','-',' '),'',$_POST['instime']));

		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit();
		break;
	case 'Elimina':
		if (empty($_POST['instime']))
			$u->deleteArticle($_POST['pageid']);
		else
			$u->declinePendant($_POST['pageid'],$_POST['instime']);

		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit();
		break;
	default:
		$_SESSION['modification']= array(
			'pageid' => $_POST['pageid'],
			'instime' => $_POST['instime']
		);

		header('Location: modificapagina.php');
		exit();
		break;
endswitch;
?>