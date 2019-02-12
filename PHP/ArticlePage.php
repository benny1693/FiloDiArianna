<?php
/**
 * Created by PhpStorm.
 * User: pincohackerino
 * Date: 03/01/19
 * Time: 12.19
 */
require_once 'Page.php';
require_once "DiscussionArea.php";

class ArticlePage extends Page{

    private $articleID = null;
    private $title = null;
    private $author = null;
    private $image = null;
    private $imageExtension = null;
    private $articleContent = null;
    private $discussionArea;

    public function __construct($articleID, $title, $author, $image, $imageExtension,$articleContent) {
        $this->articleID = $articleID;
        $this->title = $title;
        $this->author = $author;
        $this->image = $image;
        $this->imageExtension = $imageExtension;
        $this->articleContent = $articleContent;
        $this->discussionArea = new DiscussionArea();
    }

    public function getArticleID() {
        return $this->articleID;
    }

    public function getTitle() {
      return $this->title;
    }

    public function getContent() {
        return $this->articleContent;
    }

    public function getAuthor() {
      return $this->author;
    }

    public function getImage() {
        return $this->image;
    }

    public function getImageExtension() {
        return $this->imageExtension;
    }

    public function getDiscussionArea() {
        return $this->discussionArea;
    }

    public function printArticleComments($comments) {

        if (count($comments) > 0) {

            $this->discussionArea->addComments($comments);

            $this->discussionArea->printComments();
        } else {
            echo "<p>Nessuna ha ancora commentato l'articolo</p>";
        }
    }

    public function printRelatedPages($relatedPages){
        if ($relatedPages) {
            foreach ($relatedPages as $related)
                echo '<li><a href="articolo.php?articleID=' . $related['ID2'] . '">' . $related['title2'] . '</a></li>';
        } else {
            echo '<p>Nessuna pagina correlata</p>';
        }
    }

    public function showTextArea($error = null) {
        echo '
                 <form id="comment-form" action="inseriscicommento.php" method="post">
                    <input type="hidden" name="articleID" value="'.$article->getArticleID().'"/>
					<div class="form-group row">
						<label for="inputText">Lascia un commento</label>
						<textarea id="inputText" class="form-control" name="content"></textarea>
					';

        if ($error)
            printFeedback('Non puoi inviare un commento senza testo',false);

        echo '
                    </div>
					<div class="form-group row">
						<button type="submit" class="btn btn-outline-primary">Invia</button>
					</div>
				</form> ';

    }
}

?>
