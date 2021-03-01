<?php

namespace App\Model\Entity;

use Exception;
use JsonSerializable;

class Task implements JsonSerializable
{
    private $id;
    private $title;
    private $content;
    private $achieved;
    
    private $userObject;
    private $todoObject;
    private $priorityObject;
    private $taskArchivedObject;
    private $list_contribute;
    private $list_taskUpdate;

    public function __construct(int $id, string $title, string $content, int $achieved, $endDate, User $userObject, Todo $todoObject, Priority $priorityObject, TaskArchived $taskArchivedObject = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->achieved = $achieved;
        $this->endDate = $endDate;
        $this->userObject = $userObject;
        $this->todoObject = $todoObject;
        $this->priorityObject = $priorityObject;
        $this->taskArchivedObject = $taskArchivedObject;

        $this->list_contribute = array();
        $this->list_taskUpdate = array();
        
        $this->userObject->addTask($this);
        $this->todoObject->addTask($this);
        $this->priorityObject->addTask($this);
        ($this->taskArchivedObject != null) ? $this->taskArchivedObject->addTask($this) : null;
    }

    public function jsonSerialize()
    {

        return array(
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "achieved" => $this->achieved,
            "endDate" => $this->endDate,
            "userObject" => $this->userObject->jsonSerialize(),
            "todoObject" => $this->todoObject->jsonSerialize(),
            "priorityObject" => $this->priorityObject->jsonSerialize(),
            "taskArchivedObject" => $this->taskArchivedObject->jsonSerialize(),

            "list_contribute" => $this->list_contributeSerialize(),
            "list_taskUpdate" => $this->list_taskUpdateSerialize(),
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

    public function getContent()
    {
        return $this->content;
    }

    public function getAchieved()
    {
        return $this->achieved;
    }

    public function getEndDate()
    {
        return $this->achieved;
    }

    public function getUserObject()
    {
        return $this->userObject;
    }

    public function getTodoObject()
    {
        return $this->todoObject;
    }

    public function getPriorityObject()
    {
        return $this->priorityObject;
    }

    public function getTaskArchivedObject()
    {
        return $this->taskArchivedObject;
    }

    public function getList_Contribute()
    {
        return $this->list_contribute;
    }

    public function getList_TaskUpdate()
    {
        return $this->list_taskUpdate;
    }

    public function setTaskArchivedObject(TaskArchived $taskArchived)
    {
        $this->taskArchivedObject = $taskArchived;
    }

    public function removeTaskArchivedObject(){
        if($this->taskArchivedObject != null){
            $this->taskArchivedObject->removeTask($this);
            unset($this->taskArchivedObject);
        }
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
        array_push($this->list_taskUpdate, $taskUpdateObject);
    }

    public function removeTaskUpdate($taskUpdateObject)
    {
        unset($this->list_taskUpdate[array_search($taskUpdateObject, $this->list_taskUpdate)]);
    }

    private function list_ContributeSerialize()
    {
        $list_contributeSerialize = array();
        foreach ($this->list_contribute as $contribute) {
            array_push($list_contributeSerialize, $contribute->jsonSerialize());
        }

        return $list_contributeSerialize;
    }

    private function list_TaskUpdateSerialize()
    {
        $list_taskUpdateSerialize = array();
        foreach ($this->list_taskUpdate as $taskUpdate) {
            array_push($list_taskUpdateSerialize, $taskUpdate->jsonSerialize());
        }

        return $list_taskUpdateSerialize;
    }

    public function updateAttributeValue($label, $value){
        switch ($label) {
            case 'title':
                $this->$label = $value;
                break;

            case 'content':
                $this->$label = $value;
                break;

            case 'achieved':
                $this->$label = $value;
                break;

            case 'priority':
                //Suppression de la priority précédente.
                $this->priority->removeTask($this);
                $this->$label = $value;
                $this->$label->addTask($this);
                break;
            
            default:
                throw new Exception("Attribut inconnu");
                break;
        }
    }

    public function delete()
    {
        $this->userObject->removeTask($this);
        $this->todoObject->removeTask($this);
        $this->priorityObject->removeTask($this);
        ($this->taskArchivedObject != null) ? $this->taskArchivedObject->removeTask($this) : null;
    }
}
