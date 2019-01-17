<?php
/**
 * Created by PhpStorm.
 * User: pincohackerino
 * Date: 03/01/19
 * Time: 12.19
 */

require_once "Page.php";
require_once "Image.php";
require_once "DiscussionArea.php";
require_once "RegisteredUser.php";

class ArticlePage extends Page {

    private $artileID;
    private $title;
    private $author;
    private $image;
    private $articleContent;
    private $discussionArea;

    public function __construct($name, $articleID, $title, $author, $image, $articleContent, $discussionArea) {
        parent::__construct($name);
        $this->articleID = $articleID;
        $this->title = $title;
        $this->author = $author;
        $this->image = $image;
        $this->articleContent = $articleContent;
        $this->discussionArea = $discussionArea;
    }
    //tolti tutti i metodi set

    public function getArticleID() {
        return $articleID;
    }

    public function getTitle () {
      return $title;
    }

    public function getContent() {
        return $articleContent;
    }

    public function getAuthor() {
      return $author;
    }

    public function getImage() {
        return $image;
    }

    public function getDiscussionArea() {
        return $discussionArea;
    }


}

?>
