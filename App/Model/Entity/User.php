<?php

/**
 * Class to represent the User who can create a Todo with a list of Tasks.
 */

namespace App\Model\Entity;

use JsonSerializable;

class User implements JsonSerializable
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

  public function jsonSerialize()
  {
    return array(
      'id' => $this->id,
      'name' => $this->name,
      'firstname' => $this->firstname,
      'email' => $this->email,
      //'listTodo' => $this->listTodo,
      //'listTask' => $this->listTask
    );
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getFirstname()
  {
    return $this->firstname;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getListTodo()
  {
    return $this->listTodo;
  }

  public function getListTask()
  {
    return $this->listTask;
  }

  public function setListTodo($listTodo)
  {
    $this->listTodo = $listTodo;
  }

  public function setListTask($listTask)
  {
    $this->listTask = $listTask;
  }

  public function addTodo($todo)
  {
    array_push($this->listTodo, $todo);
  }

  public function addTask($task)
  {
    array_push($this->listTask, $task);
  }

  public function deleteTask($task)
  {
    unset($this->listTask[array_search($task, $this->listTask)]);
  }

  public function nbTaskValidate()
  {
    $nbTaskValidate = 0;
    foreach ($this->listTask as $value) {
      if ($value->getActive()) {
        $nbTaskValidate++;
      }
    }
    return $nbTaskValidate;
  }

  public function progressValuePourcent()
  {
    $retour = 0;
    if (count($this->listTask) > 0) {
      $retour = ($this->NbTaskValidate() / count($this->listTask)) * 100;
    }

    return $retour;
  }
}
