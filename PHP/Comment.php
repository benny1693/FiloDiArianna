<?php

require_once "RegisteredUser";


class Comment
{
  private $timeStamp;
  private $articleID;
  private $content;
  private $RegisteredUser;
  
  public function __construct($timeStamp, $articleID, $content)
  {
    $this->timeStamp=$timeStamp;
    $this->articleID=$articleID;
    $this->content=$content;
  }
  
  public function getContent()   { return $this->content;  }
  public function getTimeStamp() { return $this->timeStamp;}
  public function getAuthor() {return $RegisteredUser->getID;}
  
}

?>
