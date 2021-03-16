<?php 

namespace App;

class App
{
    private $list_priority;
    private $list_todoIcon;
    private $list_permission;

    public function __construct() {

        $this->list_priority = loadPriority();
        $this->list_todoIcon = loadTodoIcon();
        $this->list_permission = loadPermission();
    }

    public function getList_Priority()
    {
        return $this->list_priority;
    }

    public function getList_TodoIcon()
    {
        return $this->list_todoIcon;
    }

    public function getList_Permission()
    {
        return $this->list_permission;
    }


    public function setList_Priority($list_priority)
    {
        $this->list_priority = $list_priority;
    }

    public function setList_TodoIcon($list_todoIcon)
    {
        $this->list_todoIcon = $list_todoIcon;
    }

    public function setList_Permission($list_permission)
    {
        $this->list_permission = $list_permission;
    }
}
