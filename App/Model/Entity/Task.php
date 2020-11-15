<?php

/**
 * Class to represent the tasks belonging to a Todo and create by a User.
 */
class Task
{
  private $id;
  private $content;
  private $endDate;
  private $endTime;
  private $active;
  private $todoObject;
  private $userObject;

  function __construct($id, $content, $endDate, $endTime, $active, $todoObject, $userObject)
  {
    $this->id = $id;
    $this->content = $content;
    $this->endDate = $endDate;
    $this->endTime = $endTime;
    $this->active = $active;
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

  public function GET_EndTime(){
    return $this->endTime;
  }

  public function GET_Active(){
    return $this->active;
  }

  public function SET_Active($active){
    $this->active = $active;
  }

  public function GET_TodoObject(){
    return $this->todoObject;
  }

  public function GET_UserObject(){
    return $this->userObject;
  }
}

 ?>
