<?php 

namespace Model\Entity;
use JsonSerializable;

class TaskArchived implements JsonSerializable
{
    private $date;
    private $userName;
    
    private $list_task;

    function __construct($date, string $userName) {
        $this->date = $date;
        $this->userName = $userName;
        
        $this->list_task = array();
    }

    public function jsonSerialize(){
        return array(
            "date" => $this->date,
            "userName" => $this->userName,
            "list_task" => $this->list_taskSerialize(),
        );
    }

    public function getDate(){
        return $this->date;
    }

    public function getUserName(){
        return $this->userObject;
    }

    public function getList_Task(){
        return $this->list_task;
    }

    public function addTask(Task $task){
        array_push($this->list_task, $task);
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
