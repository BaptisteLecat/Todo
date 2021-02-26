<?php 

namespace Model\Entity;
use JsonSerializable;

class TodoToken implements JsonSerializable
{
    private $expirationDate;

    private $permissionObject;
    private $todoObject;

    public function __construct($expirationDate, $permissionObject, $todoObject) {
        $this->expirationDate = $expirationDate;
        $this->permissionObject = $permissionObject;
        $this->todoObject = $todoObject;

        $this->todoObject->addTodoToken($this);
        $this->permissionObject->addTodoToken($this);
    }

    public function jsonSerialize()
    {
        return array(
            'token' => $this->token,
            'expirationDate' => $this->expirationDate,
            'permissionObject' => $this->permissionObject->jsonSerialize(),
            'todoObject' => $this->todoObject->jsonSerialize()
        );
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function getPermissionObject()
    {
        return $this->permissionObject;
    }

    public function getTodoObject()
    {
        return $this->todoObject;
    }
}
