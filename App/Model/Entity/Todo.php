<?php

namespace App\Model\Entity;
use JsonSerializable;

class Todo implements JsonSerializable
{
    private $id;
    private $title;
    private $description;
    private $createDate;

    private $owned;

    private $userObject;
    private $todoIconObject;

    private $list_task;
    private $list_todoToken;
    private $list_contribute;

    //boolean OWNED permet de savoir si il s'agit d'une todo owner ou en tant que participant. 
    function __construct($id, $title, $description, $createDate, $userObject, $todoIconObject, $owned)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->createDate = $createDate;

        $this->owned = $owned;

        $this->userObject = $userObject;
        $this->todoIconObject = $todoIconObject;

        if($owned){
            $this->userObject->addTodo($this);
        }
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

    public function getOwned()
    {
        return $this->owned;
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

    public function getList_TodoToken()
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

    public function taskAchieved(){
        $list_taskAchieved = array();

        foreach ($this->list_task as $task) {
            if ($task->isAchieve()) {
                array_push($list_taskAchieved, $task);
            }
        }

        return $list_taskAchieved;
    }

    public function taskTodo()
    {
        $list_taskTodo = array();

        foreach ($this->list_task as $task) {
            if (!$task->isAchieve()) {
                array_push($list_taskTodo, $task);
            }
        }

        return $list_taskTodo;
    }

    public function delete(){
        $this->userObject->removeTodo($this);
    }

    public function havePermissionTo($permissionId){
        $haveRightTo = false;
        foreach ($this->list_contribute as $contributeObject) {
            if($contributeObject->getPermissionObject()->getId() == $permissionId){
                $haveRightTo = true;
                break;
            }
        }

        return $haveRightTo;
    }

    public function removeAllTask(){
        foreach ($this->list_task as $task) {
            $this->removeTask($task);
        }
        $this->list_task = array();
    }

    public function progressValuePercent()
    {
        $progressValue = 0;
        if (count($this->list_task) > 0) {
            $progressValue = (count($this->taskAchieved()) / count($this->list_task)) * 100;
        }

        return $progressValue;
    }
}
