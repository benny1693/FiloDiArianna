<?php
/**
 * Created by PhpStorm.
 * User: pincohackerino
 * Date: 03/01/19
 * Time: 12.18
 */

require_once "utilities.php";

class Page {

    public function printPersonalButtons() {
        print_r('<div id="member">
					<div id="icon-member">
						<svg>
							<path d="M 17.9 13.2 c 1.4 -1.4 2.3 -3.3 2.3 -5.5 c 0 -4.2 -3.5 -7.7 -7.8 -7.7 S 4.7 3.4 4.7 7.7 c 0 2.1 0.9 4.1 2.3 5.5 C 2.9 15.2 0 19.4 0 24.3 C 0 25.2 0.8 26 1.7 26 s 1.7 -0.8 1.7 -1.7 c 0 -4.9 4.1 -8.9 9.1 -8.9 s 9.1 4 9.1 8.9 c 0 0.9 0.8 1.7 1.7 1.7 s 1.7 -0.8 1.7 -1.7 C 25 19.4 22.1 15.2 17.9 13.2 Z M 8.2 7.7 c 0 -2.3 1.9 -4.2 4.3 -4.2 c 2.4 0 4.3 1.9 4.3 4.2 c 0 2.3 -1.9 4.2 -4.3 4.2 C 10.1 11.9 8.2 10 8.2 7.7 Z"></path>
						</svg>
					</div>
					<ul class="dropdown">
						<li><a href="'.addPoints().'PHP/areapersonale.php">Area Riservata</a></li>
						<li lang="en"><a href="'.addPoints().'PHP/logout.php">Logout</a></li>
					</ul>
				</div>');
    }

    //equivalente di getLoginButtons
    public function printLoginButton() {
        print_r('<a id="login-button" href="'.addPoints().'PHP/accesso.php">Accedi</a>');
    }

    public function printLogButtons() {
        if ($_SESSION['ID'] == -1)
            $this->printLoginButton();
        else
            $this->printPersonalButtons();
    }

    public function printOtherUserInfo($info) {

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

    private function printArticleListTitle($articleList){
        foreach ($articleList as $article){
            echo '
					<li><a href="articolo.php?articleID='.$article['ID'].'">' . stripslashes($article['title']) . '</a></li>';
        }
    }

    function printRandomArticlesTitle($list,$numArticles){
        // aggiungere $user->searchArticle('',$category,$subcategory); negli altri file
        $numArticles = min(abs($numArticles),count($list));

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
}

?>
