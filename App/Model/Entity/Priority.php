<?php 

namespace App\Model\Entity;
use JsonSerializable;

class Priority implements JsonSerializable
{
    private $id;
    private $label;

    private $list_task;

    public function __construct(int $id, string $label) {
        $this->id = $id;
        $this->label = $label;

        $this->list_task = array();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'label' => $this->label,
            //'list_task' => $this->list_taskSerialize()
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

    private function list_taskSerialize()
    {
        $list_taskSerialize = array();
        foreach ($this->list_task as $task) {
            array_push($list_taskSerialize, $task->jsonSerialize());
        }

        return $list_taskSerialize;
    }
}
