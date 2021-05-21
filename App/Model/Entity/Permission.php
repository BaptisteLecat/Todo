<?php

namespace App\Model\Entity;
use JsonSerializable;

class Permission implements JsonSerializable
{
    private $id;
    private $label;
    private $content;

    private $list_todoToken;
    private $listTodoContribute;

    public function __construct(int $id, string $label, string $content)
    {
        $this->id = $id;
        $this->label = $label;
        $this->content = $content;

        $this->list_todoToken = array();
        $this->listTodoContribute = array();
    }

    public function JsonSerialize()
    {
        return array(
            'id' => $this->id,
            'label' => utf8_encode($this->label),
            'content' => utf8_encode($this->content)
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

    public function getContent()
    {
        return $this->content;
    }

    public function getList_TodoToken()
    {
        return $this->list_todoToken;
    }

    public function getList_TodoContribute()
    {
        return $this->listTodoContribute;
    }

    public function addTodoToken($todoTokenObject)
    {
        array_push($this->list_todoToken, $todoTokenObject);
    }

    public function removeTodoToken($todoTokenObject)
    {
        unset($this->list_todoToken[array_search($todoTokenObject, $this->list_todoToken)]);
    }

    public function addTodoContribute($todoContributeObject)
    {
        array_push($this->listTodoContribute, $todoContributeObject);
    }

    public function removeTodoContribute($todoContributeObject)
    {
        unset($this->listTodoContribute[array_search($todoContributeObject, $this->listTodoContribute)]);
    }
}
