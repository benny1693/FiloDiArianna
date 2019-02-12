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

abstract class User {
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
        'eraeroi' => 'Epoca degli Eroi',
        'eradei' => 'Epoca degli Dei',
        'eradeiuomini' => 'Epoca degli Dei e degli Uomini',
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

	static public function isValidSubcategory($subcategory){
		return array_key_exists($subcategory, self::Category_Readble_Formats);
	}

	public function searchArticle($substring, $category = null, $subcategory = null ,$pendant = 0,$authorID = null) {

        if (self::isValidCategory($category)) {
            self::adjustCategories($category,$subcategory);
            $categoryfield = self::Category_Handlers[$category][1];

            $substring = addslashes(strtolower(trim($substring)));

            $table = ($pendant == 2 ? 'unpostedPages' : 'postedPages');

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

	public function getArticleComment($articleID) {
		$query = $this->dbconnection->query(
			"SELECT *
			FROM Prova.commentedArticles
			WHERE pageID = $articleID"
		);
		return $query->fetch_all(MYSQLI_ASSOC);
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


	function findTypeReadFormat($category, $subcategory){
        if (!empty($category) && !empty($subcategory))
            return array(
                strtoupper(substr($category,0,1)).substr($category,1), // rendo la prima lettera maiuscola
                self::Category_Readble_Formats[$subcategory] // converto la sottocategoria
            );
        else
            return null;
    }

    function getPathArticle($articleID){
        $finalQuery = null;
        $queryReadable = null;
        $query = $this->getDBConnection()->query("SELECT * FROM Prova._characters WHERE ID = $articleID");
        if($query->num_rows > 0){
            $finalQuery = $query->fetch_assoc();
            $queryReadable = self::findTypeReadFormat("personaggi" ,$finalQuery['type']);
            $finalQuery = array_merge($queryReadable,array('personaggi', $finalQuery['type']));
        }
        else {
            $query = $this->getDBConnection()->query("SELECT * FROM Prova._events WHERE ID = $articleID");
            if($query->num_rows > 0){
                $finalQuery = $query->fetch_assoc();
                $queryReadable = self::findTypeReadFormat("eventi" ,$finalQuery['era']);
                $finalQuery = array_merge($queryReadable,array('eventi', ''.$finalQuery['era']));
            }
            else{
                $query = $this->getDBConnection()->query("SELECT * FROM Prova._places WHERE ID = $articleID");
                if($query->num_rows > 0) {
                    $finalQuery = $query->fetch_assoc();
                    $queryReadable = self::findTypeReadFormat("luoghi", $finalQuery['type']);
                    $finalQuery = array_merge($queryReadable,array('luoghi', $finalQuery['type']));

                }
            }
        }

        return $finalQuery;
    }
}

?>