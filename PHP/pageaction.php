<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 07/02/19
 * Time: 22.21
 */
$u = init();

switch($_POST['action']):
	case 'Accetta':
		$u->approveArticle($_POST['pageid']);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		break;
	case 'Elimina':
		$u->deleteArticle($_POST['pageid']);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		break;
	default:
		$_SESSION['pageid'] = $_POST['pageid'];
		header('Location: modificapagina.php');
		break;
endswitch;
?>