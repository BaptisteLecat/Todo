<?php

/**
 * Class to represent the Todo created by a User, and compose with a list of Tasks.
 */

namespace App\Model\Entity;

class Todo
{
  private $id;
  private $title;
  private $active;
  private $status;
  private $createDate;
  private $listTask;
  private $userObject;

  function __construct($id, $title, $active, $status, $createDate, $userObject)
  {
    $this->id = $id;
    $this->title =$title;
    $this->active = $active;
    $this->status = $status;
    $this->createDate = $createDate;
    $this->userObject = $userObject;
    $this->userObject->AddTodo($this);
    $this->listTask = array();
  }

  public function getId(){
    return $this->id;
  }

  public function getTitle(){
    return $this->title;
  }

  public function getActive(){
    return $this->active;
  }

  public function getStatus(){
    return $this->status;
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

  public function setActive($active){
    $this->active = $active;
  }

  public function setStatus($status){
    $this->status = $status;
  }

  public function setListTask($listTask){
    $this->listTask = $listTask;
  }

  public function setUserObject($userObject){
    $this->userObject = $userObject;
  }

  public function nbTaskValidate(){
    $nbTaskValidate = 0;
    foreach ($this->listeTask as $key => $value) {
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
    foreach($this->listeTask as $key => $value){
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

  //Modifier pour pouvoir supprimer plusieurs taches.
  public function removeTask($idTask){
    foreach ($this->listeTask as $key => $value) {
      if ($value->getId() == $idTask) {
        unset($this->listeTask[array_search($value, $this->listeTask)]);
        break;
      }
    }
  }
}


 ?>
