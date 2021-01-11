<?php

namespace App\Model\Entity;

class Todo_icon
{
    private $id;
    private $libelle;
    private $list_todo;

    function  __construct($id, $libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->list_todo = array();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function getList_Todo()
    {
        return $this->list_todo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    public function setList_Todo($list_todo)
    {
        $this->list_todo = $list_todo;
    }

    public function addTodo($todoObject)
    {
        array_push($this->list_todo, $todoObject);
    }
}
