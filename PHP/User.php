<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.09
 */

require_once "DatabaseConnection.php";
require_once "ArticlePage.php";
require_once "DiscussionArea.php";

abstract class User
{
	private $dbconnection;

	public function __construct(){
		$this->dbconnection = new DatabaseConnection();
	}

	public abstract function isRegistered();

	public function searchArticle($substring, $authorID = null) {
		$substring = addslashes(strtolower(trim($substring)));

		$select = "SELECT *
								FROM Prova.postedPages 
								WHERE title LIKE '%$substring%'";

		if ($authorID)
			$select = $select . " AND author = $authorID";

		$query = $this->dbconnection->query($select);

		return $query->fetch_all(MYSQLI_ASSOC);
	}

	public function printArticleList($articleList) {
		if ($articleList == null) {
			print_r("Nessun risultato trovato");
            return;
		}

		foreach($articleList as $article) {
			echo
				'<li>
					<a href="#">
						<p>'.stripslashes($article['title']).'</p>
						<p>'.stripslashes(substr($article['content'],0,100)).'</p>
					</a>
				</li>';
		}
	}

	public function printArticleComment($articleID)
	{
		$query = $this->dbconnection->query(
			"SELECT *
			FROM Prova._comments
			WHERE pageID = $articleID
			ORDER BY time_stamp"
		);
		if ($query->num_rows > 0) {
			$result = $query->fetch_all(MYSQLI_ASSOC);

			$discussionArea = new DiscussionArea();

			foreach ($result as $comment) {
				$discussionArea->addComment(new Comment($comment['time_stamp'],$comment['pageID'],$comment['content'],$comment['author']));
			}

			$discussionArea->printComments();
		} else {
			echo "<p>Nessuna ha ancora commentato l'articolo</p>";
		}
	}

	public function getOtherUserInfo($userID) {
		$query = $this->dbconnection->query(
		"SELECT * 
			FROM Prova._users
			WHERE ID = $userID"
		);

		if ($query->num_rows > 0)
			return $query->fetch_assoc();
		else
			return null;
	}

	public function printOtherUserInfo($userID) {
		$info = $this->getOtherUserInfo($userID);

		if ($info != array()) {
			print_r(
				"<h1>Profilo di ".$info['username']."</h1>
			<h2>Dati personali</h2>
			<dl id=\"personalia\">
				<dt>Nome</dt>
				<dd>".stripslashes($info['name'])."</dd>
				<dt>Cognome</dt>
				<dd>".stripslashes($info['surname'])."</dd>
				<dt>Data di nascita</dt>
				<dd>".$info['birthDate']."</dd>
				<dt>Sesso</dt>
				<dd>".$info['gender']."</dd>
			</dl>");

			$this->printArticleList($this->searchArticle("", $info['ID']));
		} else {
			echo "<p>Utente non esistente</p>";
		}
	}

	// TODO: rendere protected questo metodo
	public function getDBConnection() {
		return $this->dbconnection;
	}
}

?>