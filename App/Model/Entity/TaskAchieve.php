<?php

namespace App\Model\Entity;

use JsonSerializable;

class TaskAchieve implements JsonSerializable
{
    private $date;
    private $userName;
    private $taskObject;
    
    function __construct($date, string $userName, Task $taskObject) {
        $this->date = $date;
        $this->userName = $userName;
        $this->taskObject = $taskObject;

        $this->taskObject->setTaskAchieveObject($this);
    }

    public function jsonSerialize(){
        return Array(
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

    public function getTaskObject(){
        return $this->taskObject;
    }
}
