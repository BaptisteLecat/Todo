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
    $this->listeTask = new ArrayObject(array());
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

  public function AddTask($task){
    array_push($this->listeTask, $task);
  }
}


 ?>
