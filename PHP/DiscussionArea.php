<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 03/01/19
 * Time: 12.20
 */

require_once "Comment.php";

class DiscussionArea {

    private $comments = array(); //array di commenti vuoto

		//public function __construct(){}

	public function addComment($comment) {  //TODO: da testare
        //mette l'elemento in fondo
    	array_push($this->comments, $comment);
    }

    public function deleteComment($comment) {   //TODO: da testare

        //scorrendo tutto l'array
        foreach($this->comments as $currentComment) {
            //ho trovato il commento da cancellare
            if($currentComment->equalTo($comment)) {
                //toglie l'elemento
                unset($this->comments[
                    key($this->comments)]   //chiave di quel valore comment
                    );
                //quindi usciamo dal ciclo
                break;
            }
        }
        //per rimettere a posto gli indici dopo aver eliminato un elemento
        $this->comments = array_values($this->comments);
    }

    public function printComments() {

    	foreach ($this->comments as $comment){
    		if ($comment->getAuthor() == $_SESSION['ID']) {
					echo "					<div class=\"comment user\">";
				} else {
					echo "					<div class=\"comment others\">";
				}

    		echo "<p>".$comment->getContent()."</p>
						<a href=\"profilopubblico.php?ID=".$comment->getAuthor()."\">".$comment->getAuthorName()."</a>   
					</div>";
			}
    }

}//getOtherUserInfo(

?>