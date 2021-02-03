<?php

class Task implements JsonSerializable
{
    private $id;
    private $title;
    private $content;
    private $achieved;
    private $endDate;
    private $createDate;

    private $userObject;
    private $todoObject;
    private $list_contribute;
    private $list_taskUpdate;
    private $list_taskArchived;

    public function __construct($id, $title, $content, $achieved, $endDate, $createDate, $userObject, $todoObject)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->achieved = $achieved;
        $this->endDate = $endDate;
        $this->createDate = $createDate;
        $this->userObject = $userObject;
        $this->todoObject = $todoObject;

        $this->list_contribute = array();
        $this->list_taskUpdate = array();
        $this->list_taskArchived = array();

        $this->userObject->addTask($this);
        $this->todoObject->addTask($this);
    }

    public function jsonSerialize()
    {

        return array(
            "id" => $this->id,
            "title" => $this->title,
            "content" => $this->content,
            "achieved" => $this->achieved,
            "endDate" => $this->endDate,
            "createDate" => $this->createDate,
            "userObject" => $this->userObject->jsonSerialize(),
            "todoObject" => $this->todoObject->jsonSerialize(),

            "list_contribute" => $this->list_contributeSerialize(),
            "list_taskUpdate" => $this->list_taskUpdateSerialize(),
            "list_taskArchived" => $this->list_taskArchivedSerialize(),
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
        return $this->endDate;
    }

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function getUserObject()
    {
        return $this->userObject;
    }

    public function getTodoObject()
    {
        return $this->todoObject;
    }

    public function getList_Contribute()
    {
        return $this->list_contribute;
    }

    public function getList_TaskUpdate()
    {
        return $this->list_taskUpdate;
    }

    public function getList_taskArchived()
    {
        return $this->list_taskArchived;
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

    public function addTaskArchived($taskArchivedObject)
    {
        array_push($this->list_taskArchived, $taskArchivedObject);
    }

    public function removeTaskArchived($taskArchivedObject)
    {
        unset($this->list_taskArchived[array_search($taskArchivedObject, $this->list_taskArchived)]);
    }


    private function list_contributeSerialize()
    {
        $list_contributeSerialize = array();
        foreach ($this->list_contribute as $contribute) {
            array_push($list_contributeSerialize, $contribute->jsonSerialize());
        }

        return $list_contributeSerialize;
    }

    private function list_taskUpdateSerialize()
    {
        $list_taskUpdateSerialize = array();
        foreach ($this->list_taskUpdate as $taskUpdate) {
            array_push($list_taskUpdateSerialize, $taskUpdate->jsonSerialize());
        }

        return $list_taskUpdateSerialize;
    }

    private function list_taskArchivedSerialize()
    {
        $list_taskArchivedSerialize = array();
        foreach ($this->list_taskArchived as $taskArchived) {
            array_push($list_taskArchivedSerialize, $taskArchived->jsonSerialize());
        }

        return $list_taskArchivedSerialize;
    }
}
