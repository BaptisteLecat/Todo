<?php

/**
 * Class to represent the Todo created by a User, and compose with a list of Tasks.
 */

namespace App\Model\Entity;

use JsonSerializable;

class Todo implements JsonSerializable
{
  private $id;
  private $title;
  private $description;
  private $active;
  private $status;
  private $endDate;
  private $endTime;
  private $createDate;
  private $listTask;
  private $userObject;

  function __construct($id, $title, $description, $active, $status, $endDate, $endTime, $createDate, $userObject)
  {
    $this->id = $id;
    $this->title =$title;
    $this->description = $description;
    $this->active = $active;
    $this->status = $status;
    $this->endDate = $endDate;
    $this->endTime = $endTime;
    $this->createDate = $createDate;
    $this->userObject = $userObject;
    $this->userObject->AddTodo($this);
    $this->listTask = array();
  }

  public function jsonSerialize()
  {
    return Array(
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'active' => $this->active,
      'status' => $this->status,
      'endDate' => $this->enDate,
      'endTime' => $this->endTime,
      'createDate' => $this->createDate,
      'userObject' => $this->userObject->jsonSerialize()
    );
  }

  public function getId(){
    return $this->id;
  }

  public function getTitle(){
    return $this->title;
  }

  public function getDescription(){
    return $this->title;
  }

  public function getActive(){
    return $this->active;
  }

  public function getStatus(){
    return $this->status;
  }

  public function getEndDate(){
    return $this->endDate;
  }

  public function getEndTime(){
    return $this->endTime;
  }

  public function getCreateDate(){
    return $this->createDate;
  }

  public function getListTask(){
    return $this->listTask;
  }

  public function getUserObject(){
    return $this->userObject;
  }


  public function setId($id){
    $this->id = $id;
  }

  public function setTitle($title){
    $this->title = $title;
  }

  public function setDescription($description){
    $this->description = $description;
  }

  public function setActive($active){
    $this->active = $active;
  }

  public function setStatus($status){
    $this->status = $status;
  }

  public function setEndDate($endDate){
    $this->endDate = $endDate;
  }

  public function setEndTime($endTime){
    $this->endTime = $endTime;
  }

  public function setCreateDate($createDate){
    $this->createDate = $createDate;
  }

  public function setListTask($listTask){
    $this->listTask = $listTask;
  }

  public function setUserObject($userObject){
    $this->userObject = $userObject;
  }

  public function nbTaskValidate(){
    $nbTaskValidate = 0;
    foreach ($this->listeTask as $value) {
      if ($value->getActive()) {
        $nbTaskValidate++;
      }
    }
    return $nbTaskValidate;
  }

  public function progressValuePourcent(){
    if(count($this->listeTask) > 0)
    return ($this->NbTaskValidate() / count($this->listeTask)) * 100;
  }

  public function validateTask($idTask){
    foreach($this->listeTask as $value){
      if($value->getId() == $idTask){
        $value->SET_Active(1);
        break;
      }
    }
  }

  public function addTask($task){
    array_push($this->listTask, $task);
    $this->userObject->addTask($task);
  }
}
