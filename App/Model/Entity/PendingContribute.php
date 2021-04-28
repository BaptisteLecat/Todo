<?php

namespace App\Model\Entity;

use JsonSerializable;

class PendingContribute implements JsonSerializable
{
    private $accepted;
    private $joinDate;

    private $todoTitle;
    private $todoOwnerName;


    function __construct($accepted, $joinDate, $todoTitle, $todoOwnerName)
    {
        $this->accepted = $accepted;
        $this->joinDate = $joinDate;

        $this->todoTitle = $todoTitle;
        $this->todoOwnerName = $todoOwnerName;
    }

    public function jsonSerialize()
    {
        return array(
            "accepted" => $this->accepted,
            "joinDate" => $this->joinDate,
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

    public function getTodoTitle()
    {
        return $this->todoTitle;
    }

    public function getTodoOwnerName()
    {
        return $this->todoOwnerName;
    }
}
