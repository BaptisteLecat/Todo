<?php

namespace App;

use Exception;
use App\Model\TaskManager;
use App\Model\TodoManager;
use App\Model\PriorityManager;
use App\Model\TodoIconManager;
use App\Model\ContributeManager;
use App\Model\PermissionManager;

class Loader
{

    public static function LoadUser($user, $list_todoIcon, $list_priority){
        self::loadUserTodo($user, $list_todoIcon);
        self::loadUserTask($user, $list_priority);
    }

    public static function loadContribute($user, $list_todoIcon, $list_permission, $list_priority){
        self::loadUserTodoContribute($user, $list_todoIcon, $list_permission);
        self::loadTodoContributeTask($user, $list_priority);
    }

    private static function loadUserTodo($user, $list_todoIcon)
    {
        try {
            TodoManager::loadTodo($user, $list_todoIcon);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    private static function loadUserTask($user, $list_priority)
    {
        try {
            foreach ($user->getList_Todo() as $todo) {
                TaskManager::loadTask($todo, $list_priority);
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    private static function loadUserTodoContribute($user, $list_todoIcon, $list_permission)
    {
        try {
            ContributeManager::loadTodoContribute($user, $list_todoIcon, $list_permission);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    private static function loadTodoContributeTask($user, $list_priority)
    {
        try {
            foreach ($user->getList_TodoContribute() as $todoContribute) {
                TaskManager::loadTask($todoContribute, $list_priority);
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function loadTodoIcon()
    {
        try {
            return TodoIconManager::loadTodoIcon();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function loadPriority()
    {
        try {
            return PriorityManager::loadPriority();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function loadPermission()
    {
        try {
            return PermissionManager::loadPermission();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }   
}
