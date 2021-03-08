<?php 

namespace App\Model\Entity;
use JsonSerializable;

class TaskUpdated implements JsonSerializable
{
    private $date;

    private $userName;
    private $taskObject;

    function __construct($date, $userName, $taskObject) {
        $this->date = $date;
        
        $this->userName = $userName;
        $this->taskObject = $taskObject;

        $this->taskObject->addTaskUpdate();
    }

    public function jsonSerialize(){
        return array(
            "date" => $this->date,
            "userName" => $this->userName,
            "taskObject" => $this->taskObject->jsonSerialize(),

        );
    }

    public function getDate(){
        return $this->date;
    }

    public function getUserName(){
        return $this->userName;
    }

    public function getTaskObject(){
        return $this->taskObject;
    }
}
