<?php

namespace Model\Entity;
use JsonSerializable;

class User implements JsonSerializable
{
    private $id;
    private $name;
    private $firstName;
    private $email;
    private $createDate;

    private $list_todo;
    private $list_task;
    private $list_contribute;
    private $list_taskUpdated;

    public function __construct($id, $name, $firstName, $email, $createDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->createDate = $createDate;

        $this->list_todo = array();
        $this->list_task = array();
        $this->list_contribute = array();
        $this->list_taskUpdated = array();
    }

    public function jsonSerialize(){

        return array(
            "id" => $this->id,
            "name" => $this->name,
            "firstName" => $this->firstName,
            "email" => $this->email,
            "createDate" => $this->createDate,

            "list_task" => $this->list_taskSerialize(),
            "list_todo" => $this->list_todoSerialize(),
            "list_contribute" => $this->list_contributeSerialize(),
            "list_taskUpdated" => $this->list_taskUpdatedSerialize(),

            "nbTaskAchieved" => $this->nbTaskAchieved(),
            "progressValue" => $this->progressValuePercent(),
        );
    }

    //Getter

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstname()
    {
        return $this->firstName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function getList_Task()
    {
        return $this->list_task;
    }
    
    public function getList_Todo()
    {
        return $this->list_todo;
    }

    public function getList_Contribute()
    {
        return $this->list_contribute;
    }

    public function getList_taskUpdated()
    {
        return $this->list_taskUpdated;
    }


    //Setters

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    // List Function | ADD - REMOVE

    public function addTask($taskObject)
    {
        array_push($this->list_task, $taskObject);
    }

    public function removeTask($taskObject)
    {
        unset($this->list_task[array_search($taskObject, $this->list_task)]);
    }

    public function addTodo($todoObject)
    {
        array_push($this->list_todo, $todoObject);
    }

    public function removeTodo($todoObject)
    {
        unset($this->list_todo[array_search($todoObject, $this->list_todo)]);
    }

    public function addContribute($contributeObject)
    {
        array_push($this->list_contribute, $contributeObject);
    }

    public function removeContribute($contributeObject)
    {
        unset($this->list_contribute[array_search($contributeObject, $this->list_contribute)]);
    }

    public function addTaskUpdate($taskUpdateObject)
    {
        array_push($this->list_taskUpdated, $taskUpdateObject);
    }

    public function removeTaskUpdate($taskUpdateObject)
    {
        unset($this->list_taskUpdated[array_search($taskUpdateObject, $this->list_taskUpdated)]);
    }

    // Functions for jsonSerialize()

    private function list_taskSerialize()
    {
        $list_taskSerialize = array();
        foreach ($this->list_task as $task) {
            array_push($list_taskSerialize, $task->jsonSerialize());
        }

        return $list_taskSerialize;
    }

    private function list_todoSerialize(){
        $list_todoSerialize = array();
        foreach ($this->list_todo as $todo) {
            array_push($list_todoSerialize, $todo->jsonSerialize());
        }

        return $list_todoSerialize;
    }

    private function list_contributeSerialize()
    {
        $list_contributeSerialize = array();
        foreach ($this->list_contribute as $contribute) {
            array_push($list_contributeSerialize, $contribute->jsonSerialize());
        }

        return $list_contributeSerialize;
    }

    private function list_taskUpdatedSerialize()
    {
        $list_taskUpdatedSerialize = array();
        foreach ($this->list_taskUpdated as $taskUpdate) {
            array_push($list_taskUpdatedSerialize, $taskUpdate->jsonSerialize());
        }

        return $list_taskUpdatedSerialize;
    }

    // Function relative to the user

    public function nbTaskAchieved()
    {
        $nbTaskAchieved = 0;
        foreach ($this->list_task as $value) {
            if ($value->getAchieved()) {
                $nbTaskAchieved++;
            }
        }
        return $nbTaskAchieved;
    }

    public function progressValuePercent()
    {
        $progressValue = 0;
        if (count($this->list_task) > 0) {
            $retour = ($this->nbTaskAchieved() / count($this->list_task)) * 100;
        }

        return $progressValue;
    }

}
