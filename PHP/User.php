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

	const Category_Readble_Formats = array (
	    'umani'=> 'Esseri Umani',
        'creature' => 'Creature',
        'eroi' => 'Semidivinit&agrave; ed Eroi',
        'dei' => 'Divinit&agrave;',
        'eraeroi' => 'Era degli Eroi',
        'eradei' => 'Era degli Dei',
        'eradeiuomini' => 'Era degli Dei e degli Uomini',
        'mitologici' => 'Mitologici',
        'reali' => 'Reali'
    );


	public function __construct(){
		$this->dbconnection = new DatabaseConnection();
	}

	public abstract function isRegistered();

	static private function adjustCategories(&$category,&$subcategory) {
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

	static public function isValidCategory($category) {

            return array_key_exists($category, self::Category_Handlers) ||
                !$category || $category == 'not_selected';

    }

	public function searchArticle($substring, $category = null, $subcategory = null ,$pendant = 0,$authorID = null) {
        if (self::isValidCategory($category)) {
            self::adjustCategories($category,$subcategory);
            $categoryfield = self::Category_Handlers[$category][1];

            $substring = addslashes(strtolower(trim($substring)));

            $table = ($pendant == 1 ? 'unpostedPages' : 'postedPages');

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
        } else
            return array();
	}

	public function printArticleListTitle($articleList){
		foreach ($articleList as $article){
			echo '
					<li><a href="articolo.php?articleID='.$article['ID'].'">' . stripslashes($article['title']) . '</a></li>';
		}
	}

	public function printArticleList($articleList, $buttons = false, $pendant = false) {

		if ($articleList != null) {
			if (!$buttons) {
				foreach ($articleList as $article){
					echo '
				<li>
					<a href="articolo.php?articleID='.$article['ID'].'">
						<p>' . stripslashes($article['title']) . '</p>
						<p>' . stripslashes(substr($article['content'], 0, 100)) . '</p>
					</a>
				</li>';
				}
			} else {
				foreach ($articleList as $article){
					echo '
										<li class="page-administration clearfix">
                        <form action="pageaction.php" method="post">
                            <a class="pagina" href="articolo.php?articleID='.$article['ID'].($pendant ? '&instime='.$article['insTime'] : '').'">
                            	<p>'.$article['title'].'</p>
                            	<p class="time">'.$article['insTime'].'</p>
                            </a>
                            <div class="bottoni">
                            		<input type="hidden" name="pageid" value="'.$article['ID'].'" />
                            		<input type="hidden" name="instime" value="'.$article['insTime'].'" />';
					if ($this->isAdmin() && $pendant)
						echo '
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
			FROM Prova.commentedArticles
			WHERE pageID = $articleID"
		);
		return $query->fetch_all(MYSQLI_ASSOC);
	}

	public function printArticleComment($comments)
	{

		if (count($comments) > 0) {

			$discussionArea = new DiscussionArea();

			foreach ($comments as $comment) {
				$discussionArea->addComment(new Comment($comment['commentTime'],$comment['pageID'],$comment['pageComment'],$comment['commentAuthor'],$comment['commentAuthorName']));
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
		}
	}

	protected function getDBConnection() {
		return $this->dbconnection;
	}

	public function getDBError() {
		return $this->dbconnection->getError();
	}

	public function getDBErrorMessage() {
		return $this->dbconnection->getErrorMessage();
	}

	public abstract function setSessionVars();

	public function isAdmin() {
		return false;
	}


	//prendere id di articolo e trova pagine correlate
    //array con id e titolo
	/**
	 * @param $articleID . Codice identificativo dell'articolo
	 * @param null $instime . Tempo di inserimento dell'articolo
	 * @return array|mixed|null . La lista delle pagine pubblicate correlate ad $articleID.
	 * 														Se $instime è null restituisce un array di pagine,
	 * 														altrimenti restituisce un array con due chiavi che indicizzano rispettivamente
	 * 														posted => l'insieme delle pagine correlate alla versione pubblicata di $articleID
	 * 														unposted => l'insieme delle pagine correlate alla versione non pubblicata di $articleID
	 */

    public function getRelatedPages($articleID,$instime = null){

				$query = $this->dbconnection->query("SELECT * FROM Prova.relatedPages WHERE ID1 = $articleID");
				$result = $query->fetch_all(MYSQLI_ASSOC);

				if ($instime != null){
					$instime = str_replace(array(':','-',' '), '', $instime);
					$query = $this->dbconnection->query("SELECT * FROM Prova.relatedPendantPages WHERE ID1 = $articleID AND insTime1 = $instime");
					$result = array('posted' => $result, 'unposted' => $query->fetch_all(MYSQLI_ASSOC));
				}

				return $result;
    }

	public function printRelatedPages($relatedPages){
		if ($relatedPages) {
			foreach ($relatedPages as $related)
				echo '<li><a href="articolo.php?articleID=' . $related['ID2'] . '">' . $related['title2'] . '</a></li>';
		} else {
			echo '<p>Nessuna pagina correlata</p>';
		}
	}


	/**
	 * @param $articleID			.codice identificativo della pagina cercata
	 * @param null $instime		tempo di inserimento
	 * @return array|null			se instime è non nullo, allora cerco anche tra le pagine modificate,
	 * 												altrimenti tra quelle non modificate
	 */
    public function getArticleInfo($articleID, $instime = null) {   //ricavo le informazioni per ArticlePage
    	$query = null;
    	if ($instime == null) {
				$query = $this->getDBConnection()->query("SELECT * FROM Prova._pages WHERE ID = $articleID");
			} else {
    		$instime = str_replace(array(':','-',' '),'',$instime);
				$query = $this->getDBConnection()->query(
					"SELECT * FROM Prova.allPages WHERE ID = $articleID AND insTime = $instime"
				);
			}

			if ($query->num_rows > 0)
					return $query->fetch_assoc();
			else
					return null;
		}

	function printRandomArticlesTitle($numArticles = null, $category = null,$subcategory=null){
		$list = $this->searchArticle('',$category,$subcategory);

		$numArticles = min($numArticles,count($list));

		$rand_keys = array_rand($list,$numArticles);
		if ($numArticles > 1) {
			$result = array();
			foreach ($rand_keys as $key) {
				array_push($result, $list[$key]);
			}
			$this->printArticleListTitle($result);
		} elseif ($numArticles == 1) {
			$this->printArticleListTitle(array($list[$rand_keys]));
		}
	}

	function findTypeReadFormat($category, $subcategory){
        if (!empty($category) && !empty($subcategory))
            return array(
                strtoupper(substr($category,0,1)).substr($category,1), // rendo la prima lettera maiuscola
                self::Category_Readble_Formats[$subcategory] // converto la sottocategoria
            );
        else
            return null;
    }

}

?>