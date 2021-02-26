<?php 

namespace Model\Entity;
use JsonSerializable;

class TaskUpdated implements JsonSerializable
{
    private $date;

    private $userObject;
    private $taskObject;

    function __construct($date, $userObject, $taskObject) {
        $this->date = $date;
        
        $this->userObject = $userObject;
        $this->taskObject = $taskObject;

        $this->userObject->addTaskArchived();
        $this->taskObject->addTaskArchived();
    }

    public function jsonSerialize(){
        return array(
            "date" => $this->date,
            "userObject" => $this->userObject->jsonSerialize(),
            "taskObject" => $this->taskObject->jsonSerialize(),

        );
    }

    public function getDate(){
        return $this->date;
    }

    public function getUserObject(){
        return $this->userObject;
    }

    public function getTaskObject(){
        return $this->taskObject;
    }
}
