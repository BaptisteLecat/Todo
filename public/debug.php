<?php 

require_once '../vendor/autoload.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\Entity\User;
use App\Model\Entity\Todo;
use App\Model\Entity\Task;

$user = new User(5, "coucou", "nom", "email");
$todoManager = new TodoManager();
$taskManager = new TaskManager();

function loadUserTodo($user, $todoManager){
    $resultLoadTodo = $todoManager->loadTodoFromUserObject($user);
    if($resultLoadTodo["success"] == 1){
        //Success.
    }
}

function loadUserTask($user, $taskManager){
    foreach($user->getListTodo() as $todo){
        $resultLoadTask = $taskManager->loadTaskFromTodoObject($todo);
        if($resultLoadTask["success"] == 1){
            //Success.
        }
    }
    
}

function loadTodoTaskFromId($idTask, $todo, $taskManager){
    $resultLoadTask = $taskManager->loadTaskFromTaskId($idTask, $todo);
    if($resultLoadTask["success"] == 1){
        //Success.
    }
}

function createTask($user, $taskManager){
    foreach ($user->getListTodo() as $todo){
        if($todo->getId() == 10){
            $resultInsertTask = $taskManager->insertTask("Sortir le chien", date("2020/11/20"), date("18:29:00"), $todo);
            if($resultInsertTask["success"] == 1){
                echo("rt:".$resultInsertTask["idTask"].": ");
                loadTodoTaskFromId($resultInsertTask["idTask"],$todo, $taskManager);
                break;
            }
        }
    }
}

loadUserTodo($user, $todoManager);
loadUserTask($user, $taskManager);
//createTask($user, $taskManager);

foreach ($user->getListTodo() as $todo){
    if($todo->getId() == 10){
        foreach ($todo->getListTask() as $value){
            echo($value->getId());
        }
        break;
    }
}

echo '    ';

foreach ($user->getListTask() as $task){
    echo($task->getContent()."   ");
}