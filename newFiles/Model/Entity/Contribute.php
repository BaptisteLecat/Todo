<?php

namespace Model\Entity;
use JsonSerializable;

class Contribute implements JsonSerializable
{
    private $accepted;
    private $joinDate;

    private $userObject;
    private $todoObject;
    private $taskObject;


    function __construct($accepted, $joinDate, $userObject, $todoObject, $taskObject)
    {
        $this->accepted = $accepted;
        $this->joinDate = $joinDate;

        $this->userObject = $userObject;
        $this->todoObject = $todoObject;
        $this->taskObject = $taskObject;

        $this->userObject->addContribute($this);
        $this->todoObject->addContribute($this);
        $this->taskObject->addContribute($this);
    }

    public function jsonSerialize()
    {

        return array(
            "accepted" => $this->accepted,
            "joinDate" => $this->joinDate,

            "userObject" => $this->userObject->jsonSerialize(),
            "todoObject" => $this->todoObject->jsonSerialize(),
            "taskObject" => $this->taskObject->jsonSerialize(),
        );
    }

    public function getAccepted()
    {
        return $this->accepted;
    }

    public function getJoinDate()
    {
        return $this->joinDate;
    }

    public function getUserObject()
    {
        return $this->userObject;
    }

    public function getTodoObject()
    {
        return $this->todoObject;
    }

    public function getTaskObject()
    {
        return $this->taskObject;
    }
}
