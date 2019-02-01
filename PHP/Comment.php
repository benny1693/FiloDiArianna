<?php

class Comment
{

  private $timeStamp = null;
  private $articleID = null;
  private $content = null;
  private $userID = null;
  
  public function __construct($timeStamp, $articleID, $content, $userID)
  {
    $this->timeStamp = $timeStamp;
    $this->articleID = $articleID;
    $this->content = $content;
    $this->userID = $userID;
  }
  
  public function getContent()   { return $this->content;  }

  public function getTimeStamp() { return $this->timeStamp;}

  public function getAuthor() {return $this->userID;}

  public function equalTo($comment) {

    if ($this->timeStamp == $comment->getTimeStamp() && $this->articleID == $comment->) {
      return true;
    }
    return false;
  }
}

?>
