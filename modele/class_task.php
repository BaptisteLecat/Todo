<?php

/**
 * Class to represent the tasks belonging to a Todo and create by a User.
 */
class Task
{
  private $id;
  private $content;
  private $endDate;
  private $status;
  private $todoObject;
  private $userObject;

  function __construct($id, $content, $endDate, $status, $todoObject, $userObject)
  {
    $this->id = $id;
    $this->content = $content;
    $this->endDate = $endDate;
    $this->status = $status;
    $this->todoObject = $todoObject;
    $this->userObject = $userObject;
    $this->todoObject->AddTask($this);
    //add list user
  }

  public function GET_Id(){
    return $this->id;
  }

  public function GET_Content(){
    return $this->content;
  }

  public function GET_EndDate(){
    return $this->endDate;
  }

  public function GET_Status(){
    return $this->status;
  }

  public function GET_TodoObject(){
    return $this->todoObject;
  }

  public function GET_UserObject(){
    return $this->userObject;
  }
}

 ?>
