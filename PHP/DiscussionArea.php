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

    public function __construct() {
    }

    public function addComment($comment) {
    	array_push($this->comments, $comment);
    }

    public function deleteComment($comment) {

    }

    public function printComments() {


    	foreach ($this->comments as $comment){
    		if ($comment->getAuthor() == $_SESSION['ID']) {
					echo "					<div class=\"comment user\">";
				} else {
					echo "					<div class=\"comment others\">";
				}
    		echo "<p>".$comment->getContent()."</p>
						<a href=\"profiloautore.html\">Autore</a>
					</div>";
			}
    }

    public function showTextArea() {

    }
}
