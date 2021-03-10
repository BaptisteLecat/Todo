<?php 

namespace App\Model\Entity;
use JsonSerializable;

class TaskArchived implements JsonSerializable
{
    private $date;
    private $userName;
    private $taskObject;

    function __construct($date, string $userName, Task $taskObject) {
        $this->date = $date;
        $this->userName = $userName;
        $this->taskObject = $taskObject;

        $this->taskObject->setTaskArchivedObject($this);
    }

    public function jsonSerialize(){
        return array(
            "date" => $this->date,
            "userName" => $this->userName,
            "taskObject" => $this->taskObject
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
}
