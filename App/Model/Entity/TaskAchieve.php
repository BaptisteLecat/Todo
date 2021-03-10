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
        return array(
            "date" => $this->date,
            "userName" => $this->userName,
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
