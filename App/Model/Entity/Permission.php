<?php

namespace App\Model\Entity;
use JsonSerializable;

class Permission implements JsonSerializable
{
    private $id;
    private $label;

    private $list_todoToken;
    private $list_contribute;

    public function __construct($id, $label)
    {
        $this->id = $id;
        $this->label = $label;

        $this->list_todoToken = array();
        $this->list_contribute = array();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'label' => $this->label,
            /*'list_todoToken' => $this->list_TodoTokenSerialize(),
            'list_contribute' => $this->list_ContributeSerialize()*/
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getList_TodoToken()
    {
        return $this->list_todoToken;
    }

    public function getList_Contribute()
    {
        return $this->list_contribute;
    }

    public function addTodoToken($todoTokenObject)
    {
        array_push($this->list_todoToken, $todoTokenObject);
    }

    public function removeTodoToken($todoTokenObject)
    {
        unset($this->list_todoToken[array_search($todoTokenObject, $this->list_todoToken)]);
    }

    public function addContribute($contributeObject)
    {
        array_push($this->list_contribute, $contributeObject);
    }

    public function removeContribute($contributeObject)
    {
        unset($this->list_contribute[array_search($contributeObject, $this->list_contribute)]);
    }
}
