<?php

/**
 * Class to represent the User who can create a Todo with a list of Tasks.
 */
class User
{
  private $id;
  private $name;
  private $firstname;
  private $email;
  private $password;
  private $listTodo;
  private $listTask;

  function __construct($id, $name, $firstname, $email, $password)
  {
    $this->id = $id;
    $this->name = $name;
    $this->firstname = $firstname;
    $this->email = $email;
    $this->password = $password;
    $this->listTodo = array();
    $this->listTask = array();
  }

  public function GET_Id(){
    return $this->id;
  }

  public function GET_Name(){
    return $this->name;
  }

  public function GET_Firstname(){
    return $this->firstname;
  }

  public function GET_Email(){
    return $this->email;
  }

  public function GET_Password(){
    return $this->password;
  }

  public function GET_ListTodo(){
    return $this->listTodo;
  }

  public function GET_ListTask(){
    return $this->listTask;
  }

  public function AddTodo($todo){
    array_push($this->listeTodo, $todo);
  }

  public function AddTask($task){
    array_push($this->listeTask, $task);
  }
}


 ?>
