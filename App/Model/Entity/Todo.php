<?php

namespace App\Model\Entity;
use App\Model\Entity\Priority;
use JsonSerializable;

class Todo implements JsonSerializable
{
    private $id;
    private $title;
    private $description;
    private $createDate;

    private $userObject;
    private $todoIconObject;

    private $list_task;
    private $list_todoToken;
    private $list_contribute;

    function __construct($id, $title, $description, $createDate, $userObject, $todoIconObject)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->createDate = $createDate;

        $this->userObject = $userObject;
        $this->todoIconObject = $todoIconObject;

        $this->userObject->addTodo($this);
        $this->todoIconObject->addTodo($this);

        $this->list_task = array();
        $this->list_todoToken = array();
        $this->list_contribute = array();
    }

    public function jsonSerialize()
    {

        return Array(
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "createDate" => $this->createDate,
            "userObject" => $this->userObject->jsonSerialize(),
            "todoIconObject" => $this->todoIconObject->jsonSerialize(),
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function getUserObject()
    {
        return $this->userObject;
    }

    public function getTodoIconObject()
    {
        return $this->todoIconObject;
    }

    public function getList_Task()
    {
        return $this->list_task;
    }

    public function getlist_todoToken()
    {
        return $this->list_todoToken;
    }

    public function getList_Contribute()
    {
        return $this->list_contribute;
    }


    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function setTodoIconObject(TodoIcon $todoIconObject)
    {
        $this->todoIconObject = $todoIconObject;
    }



    public function addTask($taskObject)
    {
        array_push($this->list_task, $taskObject);
    }

    public function removeTask($taskObject)
    {
        unset($this->list_task[array_search($taskObject, $this->list_task)]);
    }

    public function addTodoToken($todoTokenObject)
    {
        array_push($this->list_todoToken, $todoTokenObject);
    }

    public function removeTodoToken($todoTokenObject)
    {
        unset($this->list_todoToken[array_search($todoTokenObject, $this->list_todoToken)]);
    }

    public function addContribute($contributeObject)
    {
        array_push($this->list_contribute, $contributeObject);
    }

    public function removeContribute($contributeObject)
    {
        unset($this->list_contribute[array_search($contributeObject, $this->list_contribute)]);
    }
    

    public function getList_TaskNoArchived()
    {
        $list_task = array();

        foreach ($this->list_task as $task) {
            if ($task->getTaskArchivedObject() === null) {
                array_push($list_task, $task);
            }
        }

        return $list_task;
    }

    public function delete(){
        $this->userObject->removeTodo($this);
    }
}
