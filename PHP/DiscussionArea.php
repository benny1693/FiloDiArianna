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

	public function addComments($commentlist) {
        //mette l'elemento in fondo
		foreach ($commentlist as $comment) {
			array_push($this->comments,
				new Comment($comment['commentTime'],$comment['pageID'],$comment['pageComment'],
					$comment['commentAuthor'],$comment['commentAuthorName'])
			);
		}
	}

	public function deleteComment($comment) {

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

}

?>