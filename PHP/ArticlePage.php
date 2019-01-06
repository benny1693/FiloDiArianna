<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.19
 */

require_once "Page.php";
require_once "Image.php";
require_once "DiscussionArea.php";

class ArticlePage extends Page {

    private $articleID;

    public function __construct($name,$articleID) {
        parent::__construct($name);
        $this->articleID = $articleID;
    }



}