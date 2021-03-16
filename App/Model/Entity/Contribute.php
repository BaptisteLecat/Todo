<?php

namespace App\Model\Entity;
use JsonSerializable;

class Contribute implements JsonSerializable
{
    private $accepted;
    private $joinDate;

    private $permissionObject;
    private $userObject;
    private $todoObject;


    function __construct($accepted, $joinDate, $permissionObject, $userObject, $todoObject)
    {
        $this->accepted = $accepted;
        $this->joinDate = $joinDate;

        $this->permissionObject = $permissionObject;
        $this->userObject = $userObject;
        $this->todoObject = $todoObject;

        $this->userObject->addContribute($this);
        $this->todoObject->addContribute($this);
        $this->permissionObject->addContribute($this);
    }

    public function jsonSerialize()
    {
        return array(
            "accepted" => $this->accepted,
            "joinDate" => $this->joinDate,
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

    public function getPermissionObject()
    {
        return $this->permissionObject;
    }

    public function getUserObject()
    {
        return $this->userObject;
    }

    public function getTodoObject()
    {
        return $this->todoObject;
    }
}
