<?php

namespace App\Model\Entity;

use JsonSerializable;

class UserContributor implements JsonSerializable
{
    private $id;
    private $name;
    private $firstName;
    private $email;
    private $joinDate;
    private $accepted;

    private $list_permission;

    public function __construct(int $id, string $name, string $firstName, string $email, string $joinDate, bool $accepted)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->joinDate = $joinDate;
        $this->accepted = $accepted;

        $this->list_permission = array();
    }

    public function JsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => utf8_encode(
                $this->name
            ),
            'firstName' => utf8_encode(
                $this->firstName
            ),
            'email' => utf8_encode(
                $this->email
            ),
            'joinDate' => $this->joinDate,
            'permission' => $this->serializePermission(),
            'accepted' => $this->accepted,
        );
    }

    private function serializePermission()
    {
        $serializedPermission = array();
        foreach ($this->list_permission as $permission) {
            array_push($serializedPermission, $permission->jsonSerialize());
        }
        return $serializedPermission;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getJoinDate()
    {
        return $this->joinDate;
    }

    public function getAccepted()
    {
        return $this->accepted;
    }

    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }


    public function getList_Permission()
    {
        return $this->list_permission;
    }


    public function addPermission(Permission $permissionObject)
    {
        array_push($this->list_permission, $permissionObject);
    }

    public function removePermission(Permission $permissionObject)
    {
        unset($this->list_permission[array_search($permissionObject, $this->list_permission)]);
    }

    public function havePermission(Permission $permissionObject)
    {
        $havePermission = false;

        foreach ($this->list_permission as $permission) {
            if ($permission->getId() == $permissionObject->getId()) {
                $havePermission = true;
            }
        }

        return $havePermission;
    }
}
