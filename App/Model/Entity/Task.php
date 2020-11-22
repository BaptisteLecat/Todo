<?php

/**
 * Class to represent the tasks belonging to a Todo and create by a User.
 */

namespace App\Model\Entity;

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

  public function getId(){
    return $this->id;
  }

  public function getContent(){
    return $this->content;
  }

  public function getEndDate(){
    return $this->endDate;
  }

  public function getEndTime(){
    return $this->endTime;
  }

  public function getActive(){
    return $this->active;
  }

  public function setActive($active){
    $this->active = $active;
  }

  public function getTodoObject(){
    return $this->todoObject;
  }

  public function getUserObject(){
    return $this->userObject;
  }
}

 ?>
