<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.20
 */

require_once "Comment.php";

class DiscussionArea
{
    private $comments = []; //array di commenti

    public function __construct($comments) {
        $this->comments = $comments;
    }

    public function addComment($comment) {
        array_push($comments, $comment);  //lo mette in coda
    }

    public function deleteComment($comment) {

    }

    public function printComments() {
        print_r($comments); //o var_dump($comments);
    }

    public function showTextArea() {

    }


}
