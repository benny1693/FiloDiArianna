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


	const Category_Handlers = array(
		'personaggi' => array(
			'_characters',
			'type',
			array(
				'umani',
				'creature',
				'dei',
				'eroi'
			)
		),
		'eventi' => array(
			'_events',
			'era',
			array(
				'eradeiuomini',
				'eradei',
				'eraeroi'
			)
		),
		'luoghi' => array(
			'_places',
			'type',
			array(
				'mitologici',
				'reali'
			)
		)
	);

	public function __construct(){
		$this->dbconnection = new DatabaseConnection();
	}

	public abstract function isRegistered();

	private function adjustCategories(&$category,&$subcategory) {
		if ($category) {
			if (!array_key_exists($category, self::Category_Handlers)) {
				$category = null;
				$subcategory = null;
			} else {
				if (!in_array($subcategory,self::Category_Handlers[$category][2])) {
					$subcategory = null;
				}
			}
		} else {
			$subcategory = null;
		}
	}

	public function searchArticle($substring, $category = null, $subcategory = null ,$pendant = false,$authorID = null) {

		$this->adjustCategories($category,$subcategory);
		$categoryfield = self::Category_Handlers[$category][1];

		$substring = addslashes(strtolower(trim($substring)));

		$table = ($pendant ? 'unpostedPages' : 'postedPages');

		$select = "SELECT *
								FROM Prova.$table";

		if ($category) {
			$category = self::Category_Handlers[$category][0];
			$select = $select . " NATURAL JOIN Prova.$category";
		}
		$select = $select . " WHERE title LIKE '%$substring%'";

		if ($subcategory) {
			$select = $select . " AND $categoryfield = '$subcategory'";
		}

		if ($authorID)
			$select = $select . " AND author = $authorID";

		$query = $this->dbconnection->query($select);

		return $query->fetch_all(MYSQLI_ASSOC);
	}

	public function printArticleList($articleList, $buttons = false, $pendant = false) {

		if ($articleList != null) {
			if (!$buttons) {
				foreach ($articleList as $article)
					echo '
				<li>
					<a href="#">
						<p>' . stripslashes($article['title']) . '</p>
						<p>' . stripslashes(substr($article['content'], 0, 100)) . '</p>
					</a>
				</li>';
			} else {
				foreach ($articleList as $article){
					echo '
										<li class="page-administration clearfix">
                        <form action="pageaction.php" method="post">
                            <a class="pagina" href="articolo.php?articleID='.$article['ID'].'">'.$article['title'].'</a>
                            <div class="bottoni">
                            		<input type="hidden" name="pageid" value="'.$article['ID'].'" />';
					if ($this->isAdmin() && $pendant)
						echo '
                  							<input type="hidden" name="instime" value="'.$article['insTime'].'" />
                                <input type="submit" class="btn  btn-outline-primary" name="action" value="Accetta" />';
					echo '
                                <input type="submit" class="btn btn-outline-primary" name="action" value="Modifica" />
                                <input type="submit" class="btn btn-outline-primary" name="action" value="Elimina" />
                            </div>
                        </form>
                    </li>';
				}
			}
		}
	}


	public function getArticleComment($articleID) {
		$query = $this->dbconnection->query(
			"SELECT *
			FROM Prova._comments
			WHERE pageID = $articleID
			ORDER BY time_stamp"
		);
		return $query->fetch_all(MYSQLI_ASSOC);
	}

	public function printArticleComment($comments)
	{

		if (count($comments) > 0) {

			$discussionArea = new DiscussionArea();

			foreach ($comments as $comment) {
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

	public abstract function setSessionVars();

	public function isAdmin() {
		return false;
	}


	//prendere id di articolo e trova pagine correlate
    //array con id e titolo
    public function getRelatedPages($articleID){

        $query = $this->dbconnection->query(
            "SELECT * 
			FROM Prova._relatedPages
			WHERE ID = $articleID"
        );

        if ($query->num_rows > 0)
            return $query->fetch_all(MYSQLI_ASSOC);
        else
            return null;
    }

    public function printRelatedPages($articleID) {
        $array = $this->getRelatedPages($articleID);
        foreach ($array as $art){
            echo $art['title'];
        }
    }

    public function getArticleInfo($articleID) {   //ricavo le informazioni per ArticlePage
	    if($this->isAdmin()) {
            $query = $this->dbconnection->query(
                "SELECT * 
                FROM Prova.unpostedPages
                WHERE ID = $articleID");
        }
	    else{   //se non admin posted
            $query = $this->dbconnection->query(
                "SELECT * 
                FROM Prova.postedPages
                WHERE ID = $articleID");
        }

        if ($query->num_rows > 0)
            return $query->fetch_assoc();
        else
            return null;
    }

}

?>