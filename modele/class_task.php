<?php

/**
 *
 */
class Task
{
  private $id;
  private $title;
  private $dateStart;
  private $statut;
  private $todoObject;

  function __construct($id, $content, $dateStart, $statut, $todoObject)
  {
    $this->id = $id;
    $this->content = $content;
    $this->dateStart = $dateStart;
    $this->statut = $statut;
    $this->todoObject = $todoObject;
    var_dump(get_object_vars($this));
  }

  public function GET_Id(){
    return $this->id;
  }

  public function GET_Content(){
    return $this->content;
  }

  public function GET_DateStart(){
    return $this->dateStart;
  }

  public function GET_Statut(){
    return $this->statut;
  }

  public function GET_TodoObject(){
    return $this->todoObject;
  }
}


 ?>
