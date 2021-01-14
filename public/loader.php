<?php

function loadUserTodo($user, $todoManager, $todoIconManager)
{
    $resultLoadIcon = $todoIconManager->loadTodoIcon();
    if ($resultLoadIcon["success"] == 1) {
        $resultLoadTodo = $todoManager->loadTodoFromUserObject($user, $resultLoadIcon["list_todoIcons"]);
        if ($resultLoadTodo["success"] == 1) {
            //Success.
        }
    }
}

function loadUserTask($user, $taskManager)
{
    foreach ($user->getListTodo() as $todo) {
        $resultLoadTask = $taskManager->loadTaskFromTodoObject($todo);
        if ($resultLoadTask["success"] == 1) {
            //Success.
        }
    }
}

function drainUser($user){
    //Permet de recharger la liste de task et de Todo sans avoir de doublon.
    if ($user->getListTask() != null) {
        $user->setListTask(array());
    }

    if ($user->getListTodo() != null) {
        $user->setListTodo(array());
    }
}