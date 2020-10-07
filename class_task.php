<?php

/**
 *
 */
class Task
{
  private $title;
  private $dateStart;
  private $statut;
  private $todoObject;

  function __construct($title, $dateStart, $statut, $todoObject)
  {
    $this->title = $title;
  }
}


 ?>
