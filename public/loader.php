<?php

use App\Model\PriorityManager;
use App\Model\TaskManager;
use App\Model\TodoIconManager;
use App\Model\TodoManager;
use App\Model\ContributeManager;

function loadUserTodo($user, $list_todoIcon)
{
    try {
        TodoManager::loadTodo($user, $list_todoIcon);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

function loadUserTodoContribute($user, $list_todoIcon){
    try {
        ContributeManager::loadTodoContribute($user, $list_todoIcon);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

function loadUserTask($user, $list_priority)
{
    try {
        foreach ($user->getList_Todo() as $todo) {
            TaskManager::loadTask($todo, $list_priority);
        }
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

function drainUser($user)
{
    //Permet de recharger la liste de task et de Todo sans avoir de doublon.
    if ($user->getList_Task() != null) {
        $user->drainTask();
    }

    if ($user->getList_Todo() != null) {
        $user->drainTodo();
    }
}

function loadTodoIcon()
{
    try {
        return TodoIconManager::loadTodoIcon();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

function loadPriority()
{
    try {
        return PriorityManager::loadPriority();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}
