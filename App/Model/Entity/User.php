<?php

/**
 * Class to represent the User who can create a Todo with a list of Tasks.
 */

 namespace App\Model\Entity;
 
class User
{
  private $id;
  private $name;
  private $firstname;
  private $email;
  private $listTodo;
  private $listTask;

  function __construct($id, $name, $firstname, $email)
  {
    $this->id = $id;
    $this->name = $name;
    $this->firstname = $firstname;
    $this->email = $email;
    $this->listTodo = array();
    $this->listTask = array();
  }

  public function getId(){
    return $this->id;
  }

  public function getName(){
    return $this->name;
  }

  public function getFirstname(){
    return $this->firstname;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getListTodo(){
    return $this->listTodo;
  }

  public function getListTask(){
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
