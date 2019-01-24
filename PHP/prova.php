<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 04/01/19
 * Time: 17.58
 */

require_once 'UnregisteredUser.php';

$u = new UnregisteredUser();

echo "<p>Ricerca degli articoli</p>";
$articleList = $u->searchArticle("",1);

$u->printArticleList($articleList);

echo "<p>Ricerca dei commenti</p>";

$u->printArticleComment(1);

echo "<p>Informazione di un altro utente</p>";

$u->printOtherUserInfo(1);
?>