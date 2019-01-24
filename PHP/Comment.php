<?php

class Comment
{

  private $timeStamp;
  private $articleID;
  private $content;
  private $userID;
  
  public function __construct($timeStamp, $articleID, $content, $userID)
  {
    $this->timeStamp=$timeStamp;
    $this->articleID=$articleID;
    $this->content=$content;
    $this->userID = $userID;
  }
  
  public function getContent()   { return $this->content;  }
  public function getTimeStamp() { return $this->timeStamp;}
  public function getAuthor() {return $this->userID;}

}

?>
