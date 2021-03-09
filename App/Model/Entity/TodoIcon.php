<?php 

namespace App\Model\Entity;
use JsonSerializable;

class TodoIcon implements JsonSerializable
{
    private $id;
    private $label;
    
    private $list_todo;

    public function __construct($id, $label) {
        $this->id = $id;
        $this->label = $label;

        $this->list_todo = array();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'label' => $this->label,
            //'list_todo' => $this->list_todoSerialize()
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

    public function getList_Todo()
    {
        return $this->list_todo;
    }

    public function addTodo($todoObject)
    {
        array_push($this->list_todo, $todoObject);
    }

    public function removeTodo($todoObject)
    {
        unset($this->list_todo[array_search($todoObject, $this->list_todo)]);
    }
}
