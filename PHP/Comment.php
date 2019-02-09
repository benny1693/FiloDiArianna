<?php

class Comment
{

  private $timeStamp = null;
  private $articleID = null;
  private $content = null;
  private $userID = null;
  private $userName = null;
  public function __construct($timeStamp, $articleID, $content, $userID,$userName)
  {
    $this->timeStamp = $timeStamp;  //date
    $this->articleID = $articleID;  //int
    $this->content = $content;  //string
    $this->userID = $userID;  //è l'autore del commento
    $this->userName = $userName;
  }
  
  public function getContent()  { return stripslashes($this->content);  }

  public function getTimeStamp()  { return $this->timeStamp; }

  public function getAuthor() { return $this->userID; }

  public function getAuthorName() { return $this->userName; }

  public function getArticleID()  { return $this->articleID; }

  public function equalTo(Comment $comment) { //TODO: vedere se va senza Comment

    if ($this->timeStamp == $comment->getTimeStamp() && $this->userID == $comment->getAuthor() &&
        $this->articleID == $comment->getArticleID() && $this->content == $comment->getContent()) {
      return true;
    }
    return false;
  }

}

?>
