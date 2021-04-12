<?php 

namespace App\Model\Entity;
use JsonSerializable;

class TodoToken implements JsonSerializable
{
    private $token;
    private $expirationDate;

    private $permissionObject;
    private $todoObject;

    public function __construct($token, $expirationDate, $permissionObject, $todoObject) {
        $this->token = $token;
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

    public function getToken(){
        return $this->token;
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
