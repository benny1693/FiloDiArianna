<?php
/**
 * Created by PhpStorm.
 * User: pincohackerino
 * Date: 03/01/19
 * Time: 12.19
 */

require_once "Page.php";
require_once "DiscussionArea.php";

class ArticlePage extends Page {

    private $articleID = null;
    private $title = null;
    private $author = null;
    private $image = null;
    private $articleContent = null;
    private $discussionArea;

    public function __construct($articleID, $title, $author, $image, $articleContent) {
        $this->articleID = $articleID;
        $this->title = $title;
        $this->author = $author;
        $this->image = $image;
        $this->articleContent = $articleContent;
        $this->discussionArea = new DiscussionArea();
    }

    public function getArticleID() {
        return $this->articleID;
    }

    public function getTitle () {
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

    public function getDiscussionArea() {
        return $this->discussionArea;
    }


}

?>
