<?php

namespace App\Model\Entity;

use JsonSerializable;

class PendingContribute implements JsonSerializable
{
    private $accepted;
    private $joinDate;

    private $todoId;
    private $todoTitle;
    private $todoOwnerName;


    function __construct($accepted, $joinDate, $todoId, $todoTitle, $todoOwnerName)
    {
        $this->accepted = $accepted;
        $this->joinDate = $joinDate;

        $this->todoId = $todoId;
        $this->todoTitle = $todoTitle;
        $this->todoOwnerName = $todoOwnerName;
    }

    public function jsonSerialize()
    {
        return array(
            "accepted" => $this->accepted,
            "joinDate" => $this->joinDate,
            "todoId" => $this->todoId,
            "todoTitle" => $this->todoTitle,
            "todoOwnerName" => $this->todoOwnerName
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

    public function getTodoId()
    {
        return $this->todoId;
    }

    public function getTodoTitle()
    {
        return $this->todoTitle;
    }

    public function getTodoOwnerName()
    {
        return $this->todoOwnerName;
    }
}
