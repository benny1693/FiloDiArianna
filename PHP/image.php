<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 08/02/19
 * Time: 2.32
 */
include_once 'Admin.php';

$u = null;
try {
	$u = new Admin('ciccio90');
} catch (Exception $exc) {

}

print_r($_FILES);

// inserimento immagine
$data = file_get_contents($_FILES['image']['tmp_name']);
$path = $_FILES['image']['name'];
$type = pathinfo($path, PATHINFO_EXTENSION);
$u->insertArticle('title',null,$data,1,array('personaggi','eroi'),array());

// recupero e stampa immagine
$article = $u->searchArticle('title',null,null,true);
$u->approveArticle($article[0]['ID']);
$article = $u->searchArticle('title');
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($article[0]['img']);
echo '<img src="'.$base64.'"/>';

/*
$path = '/home/benedetto/Scrivania/section8-image.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$u->insertArticle('fiore','interessante',$data,1,array('personaggi','eroi'),array());
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
*/
?>

