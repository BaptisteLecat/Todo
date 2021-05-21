<?php

namespace App\Model\Entity;

use JsonSerializable;
use App\Model\Entity\User;
use App\Model\Entity\TodoIcon;

class TodoContribute extends Todo implements JsonSerializable
{
    private $userOwner;
    private $joinDate;
    private $accepted;
    private $listPermission;

    function __construct(int $id, string $title, string $description, string $createDate, User $user, TodoIcon $todoIcon, User $userOwner, string $joinDate, bool $accepted)
    {
        parent::__construct($id, $title, $description, $createDate, $user, $todoIcon);
        $this->userOwner = $userOwner;
        $this->joinDate = $joinDate;
        $this->accepted = $accepted;
        $this->listPermission = array();
    }

    public function jsonSerialize()
    {
        return array(
            "userOwner" => $this->userOwner,
            "joinDate" => $this->joinDate,
            "accepted" => $this->accepted
        );
    }

    public function getUserOwner()
    {
        return $this->userOwner;
    }

    public function getJoinDate()
    {
        return $this->joinDate;
    }

    public function getAccepted()
    {
        return $this->accepted;
    }

    public function getList_Permission()
    {
        return $this->listPermission;
    }

    public function havePermissionTo($permissionId)
    {
        $haveRightTo = false;
        foreach ($this->listPermission as $permission) {
            if ($permission->getId() == $permissionId) {
                $haveRightTo = true;
                break;
            }
        }

        return $haveRightTo;
    }


    public function addPermission($permissionObject)
    {
        array_push($this->listPermission, $permissionObject);
        //On ajoute l'object courant dans la liste des todoContribute de l'object Permission.
        $permissionObject->addTodoContribute($this);
    }

    public function removePermission($permissionObject)
    {
        unset($this->listPermission[array_search($permissionObject, $this->listPermission)]);
        //On retire l'object courant de la liste des todoContribute de l'object Permission.
        $permissionObject->removeTodoContribute($this);
    }
}
