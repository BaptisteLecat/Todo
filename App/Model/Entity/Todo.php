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
  private $listeTask;
  private $userObject;

  function __construct($id, $title, $active, $status, $userObject)
  {
    $this->id = $id;
    $this->title =$title;
    $this->active = $active;
    $this->status = $status;
    $this->userObject = $userObject;
    $this->listeTask = array();
  }

  public function GET_Id(){
    return $this->id;
  }

  public function GET_Title(){
    return $this->title;
  }

  public function GET_Active(){
    return $this->active;
  }

  public function GET_Status(){
    return $this->status;
  }

  public function GET_ListeTask(){
    return $this->listeTask;
  }

  public function GET_UserObject(){
    return $this->userObject;
  }

  public function NbTaskValidate(){
    $nbTaskValidate = 0;
    foreach ($this->listeTask as $key => $value) {
      if ($value->GET_Active()) {
        $nbTaskValidate++;
      }
    }
    return $nbTaskValidate;
  }

  public function ProgressValuePourcent(){
    if(count($this->listeTask) > 0)
    return ($this->NbTaskValidate() / count($this->listeTask)) * 100;
  }

  public function ValidateTask($idTask){
    foreach($this->listeTask as $key => $value){
      if($value->GET_Id() == $idTask){
        $value->SET_Active(1);
        break;
      }
    }
  }

  public function AddTask($task){
    array_push($this->listeTask, $task);
  }

  //Modifier pour pouvoir supprimer plusieurs taches.
  public function RemoveTask($idTask){
    foreach ($this->listeTask as $key => $value) {
      if ($value->GET_Id() == $idTask) {
        unset($this->listeTask[array_search($value, $this->listeTask)]);
        break;
      }
    }
  }
}


 ?>
