<?php

/**
 *
 */
class Todo
{
  private $id;
  private $title;
  private $listeTask;

  function __construct($id, $title)
  {
    $this->id = $id;
    $this->title =$title;
    $this->listeTask = array();
  }

  public function GET_Id(){
    return $this->id;
  }

  public function GET_Title(){
    return $this->title;
  }

  public function GET_ListeTask(){
    return $this->listeTask;
  }

  public function GET_NbTaskValidate(){
    $nbTaskValidate = 0;
    foreach ($this->listeTask as $key => $value) {
      if ($value->GET_Statut()) {
        $nbTaskValidate++;
      }
    }
    return $nbTaskValidate;
  }

  public function GET_ProgressValuePourcent(){
    return ($this->GET_NbTaskValidate() / count($this->listeTask)) * 100;
  }

  public function AddTask($task){
    array_push($this->listeTask, $task);
  }

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
