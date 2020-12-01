<?php

/**
 * Class to represent the tasks belonging to a Todo and create by a User.
 */

namespace App\Model\Entity;

use JsonSerializable;

class Task implements JsonSerializable
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

  public function jsonSerialize(){
    return Array(
      'id' => $this->id,
      'content' => $this->content,
      'endDate' => $this->endDate,
      'endTime' => $this->endTime,
      'active' => $this->active,
      'todoObject' => $this->todoObject->jsonSerialize(),
      'userObject' => $this->userObject->jsonSerialize(),
    );
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

  public function getTodoObject(){
    return $this->todoObject;
  }

  public function getUserObject(){
    return $this->userObject;
  }

  public function setActive($active){
    $this->active = $active;
  }

  public function setContent($content){
    $this->content = $content;
  }

  public function setEndDate($endDate){
    $this->endDate = $endDate;
  }

  public function setEndTime($endTime){
    $this->endTime = $endTime;
  }

  public function setTodoObject($todoObject){
    $this->todoObject = $todoObject;
  }
}
