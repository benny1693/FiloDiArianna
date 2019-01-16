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

    private $articleID;
    private $author;
    private $image;
    private $title;
    private $

    public function __construct($name, $articleID, $author, $image) {
        parent::__construct($name);
        $this->articleID = $articleID;
        
    }

    public function setDiscussionArea() {
        $this->
    }

    public function setTitle($title){
        $this->title = title;
    }

    public function getImage() {
        return $image;
    }

    public function getAuthor() {
      return $author;
    }

    public function getDiscussionArea() {

    }

    public function getTitle () {
      return $title;
    }

}

?>
