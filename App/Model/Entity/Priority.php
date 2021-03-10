<?php 

namespace App\Model\Entity;
use JsonSerializable;

class Priority implements JsonSerializable
{
    private $id;
    private $label;
    private $color;

    private $list_task;

    public function __construct(int $id, string $label, string $color) {
        $this->id = $id;
        $this->label = $label;
        $this->color = $color;

        $this->list_task = array();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'label' => $this->label,
            'color' => $this->color,
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

    public function getColor(){
        return $this->color;
    }

    public function getList_Task()
    {
        return $this->list_task;
    }

    public function addTask($taskObject)
    {
        array_push($this->list_task, $taskObject);
    }

    public function removeTask($taskObject)
    {
        unset($this->list_task[array_search($taskObject, $this->list_task)]);
    }
}
