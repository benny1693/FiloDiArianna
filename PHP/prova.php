<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 04/01/19
 * Time: 17.58
 */

require_once 'UnregisteredUser.php';
require_once 'RegisteredUser.php';
require_once 'Admin.php';
require_once "Page.php";
require_once "DiscussionArea.php";

$u = null;
try {
	$u = new RegisteredUser('ciccio90');
	$_SESSION['ID'] = $u->getID();

	print_r($_SESSION);

} catch (Exception $exception) {
	$u = new UnregisteredUser();
}


/*
$a = null;
$b = null;
$c = null;

$a = new Page('Pagina Dei');
$a->printLoginButtons();
$img = new Image('img');

$a = new ArticlePage('Nome Atena', '1111', 'Titolo Atena', $u->getID(), $img ,'Questo è il 
conenuto di articolo');
$contenuto = $a->getContent();
echo $contenuto;
$autore = $a->getAuthor();
$titolo = $a->getTitle();
echo $autore.$titolo;

$c1 = new Comment('13:38', $a->getArticleID(), 'Questo è un fottutisso fottutissimissimo commento. 
La pagina di Atena fa schifo, bleah.', $u->getID());
$c2 = new Comment('13:48', $a->getArticleID(), 'No dai, forse la pagina di Atena mi piace.', $u->getID());
$b = $a->getDiscussionArea();
$b->addComment($c1);
$b->addComment($c2);
$b->printComments();
echo '--- Ora ho cancellato il primo commento ---';
$b->deleteComment($c1);
$b->printComments();

echo '-------FINE PROVE LAURA --------';
*/

echo "<h1>Funzionalità generiche</h1>";

echo "<h2>Ricerca degli articoli con autore</h2>";
$articleList = $u->searchArticle("",1);
$u->printArticleList($articleList);

echo "<h2>Ricerca degli articoli senza autore</h2>";
$articleList = $u->searchArticle("ao1");

$u->printArticleList($articleList);

echo "<h2>Ricerca dei commenti</h2>";


$u->printArticleComment($u->getArticleComment(1));

echo "<h2>Informazione di un altro utente</h2>";

$u->printOtherUserInfo(1);

echo "<h1>Funzionalità esclusive utenti registrati</h1>";

echo "<h2>Inserimento di un articolo (titolo = hello)</h2>";

$u->insertArticle("L'ira di Zeus",'NULL','NULL',1,array('personaggio','creatura'),array(2,3));

$query = $u->getDBConnection()->query("SELECT * FROM Prova._pages");
$result = $query->fetch_all(MYSQLI_ASSOC);

$u->printArticleList($result);

$query = $u->getDBConnection()->query("SELECT * FROM Prova._pendantRelations");
$result = $query->fetch_all(MYSQLI_ASSOC);
print_r($result);

echo "<h2>Eliminazione di un articolo</h2>";
$query = $u->getDBConnection()->query(
	"SELECT * FROM Prova.`_pages` WHERE title = '" . addslashes("L'ira di Zeus") . "'"
);
$ID = $query->fetch_assoc()['ID'];

$u->deleteArticle($ID);

$query = $u->getDBConnection()->query("SELECT * FROM Prova._pages");
$result = $query->fetch_all(MYSQLI_ASSOC);

$u->printArticleList($result);

echo "<h2>Modifica di un articolo</h2>";

$u->modifyArticle(2,"allora l'approviamo?",'NULL',array('personaggi','dei'),array(3));

$query = $u->getDBConnection()->query("SELECT * FROM Prova._modifiedPages");
$result = $query->fetch_all(MYSQLI_ASSOC);

print_r($result);

echo "<h2>Inserimento di un commento</h2>";

$u->insertComment(1,"anch'io penso che sia un bell'articolo");

$u->printArticleComment($u->getArticleComment(1));

echo "<h1>Funzionalità esclusive degli utenti non registrati</h1>";

$u = new UnregisteredUser();

echo "<h2>Registrazione</h2>";

echo $u->subscribe('mario',"dall'anese",'M','2012-12-12','mrossi@italia.it',
									'mdall','aaaa');
echo "<br/>";

$query = $u->getDBConnection()->query('SELECT * FROM Prova._users');
$result = $query->fetch_all(MYSQLI_ASSOC);

print_r($result);

echo "<h1>Funzionalità esclusive degli admin</h1>";

try {
	$u = new Admin('ciccio90');
	$_SESSION['ID'] = $u->getID();

	print_r($_SESSION);

} catch (Exception $exception) {
	$u = new UnregisteredUser();
}

echo "<h2>Ricerca e stampa di uno o più utenti</h2>";

echo "<h3>Ricerca di un utente con sottostringa vuota</h3>";
$u->printUserList($u->findUser(''));

echo "<h3>Ricerca di un utente con sottostringa 'ciccio'</h3>";
$u->printUserList($u->findUser('ciccio'));

echo "<h2>Eliminazione di un utente</h2>";

$query = $u->getDBConnection()->query("SELECT ID FROM Prova.`_users` WHERE username = 'mdall'");

$u->deleteUser($query->fetch_row()[0]);

$u->printUserList($u->findUser(''));

echo "<h2>Approvazione di un articolo</h2>";

echo "<h3>Approvazione di un articolo modificato</h3>";
$select = "SELECT modTime FROM Prova._modifiedPages WHERE ID = 2";
$query = $u->getDBConnection()->query($select);
echo $timestamp = $query->fetch_row()[0];

echo "<h4>Prima</h4>";
$query = $u->getDBConnection()->query($select);
$result = $query->fetch_all(MYSQLI_ASSOC);
print_r($result);

$u->approveArticle(2,$timestamp);

echo "<h4>Dopo</h4>";
$query = $u->getDBConnection()->query($select);
$result = $query->fetch_all(MYSQLI_ASSOC);
print_r($result);

echo "<h3>Approvazione di un articolo non modificato</h3>";

$u->insertArticle('prova','ciao','NULL',1,array("luogo","reale"),array(3));

echo "<h4>Prima</h4>";
$select = "SELECT ID,insTime,posted, pR.ID1 AS prel1, pR.ID2 AS prel2
					FROM Prova.`_pages` AS P, Prova.`_pendantRelations` AS pR
					WHERE P.ID = pR.ID1 AND title = 'prova'";
$query = $u->getDBConnection()->query($select);
$result = $query->fetch_all(MYSQLI_ASSOC);
print_r($result);

print_r($result[0]['ID']);

$u->approveArticle($result['0']['ID']);

echo $u->getDBConnection()->getConnection()->sqlstate;

echo "<h4>Dopo</h4>";
$select = "SELECT ID,insTime,posted, R.ID1 AS rel1, R.ID2 AS rel2
					FROM Prova.`_pages` AS P, Prova.`_relations` AS R
					WHERE P.ID = R.ID1 AND title = 'prova'";
$query = $u->getDBConnection()->query($select);
$result = $query->fetch_all(MYSQLI_ASSOC);
print_r($result);

$query = $u->getDBConnection()->query("SELECT ID FROM Prova.`_pages` WHERE title = 'prova'");
$result = $query->fetch_assoc();

print_r($result);

$u->deleteArticle($result['ID']);

?>