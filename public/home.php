<?php 

require_once '../vendor/autoload.php';
<<<<<<< Updated upstream
=======
require 'module/dayDisplayer.php';
>>>>>>> Stashed changes

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\Entity\User;
use App\Model\Entity\Todo;
use App\Model\Entity\Task;

session_start();
$user = unserialize($_SESSION["User"]);
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

loadUserTodo($user, $todoManager);
loadUserTask($user, $taskManager);
$_SESSION["User"] = serialize($user);
$taskForToday = taskForToday($user);
$nbTaskValidate = nbTaskValidate($taskForToday);
var_dump(unserialize($_SESSION["User"]));


/*function loadTodoTaskFromId($idTask, $todo, $taskManager){
    $resultLoadTask = $taskManager->loadTaskFromTaskId($idTask, $todo);
    if($resultLoadTask["success"] == 1){
        //Success.
    }
}

function createTask($user, $taskManager){
    foreach ($user->getListTodo() as $todo){
        if($todo->getId() == 10){
            $resultInsertTask = $taskManager->insertTask("Sortir le chien", date("Y-m-d"), date("18:29:00"), $todo);
            if($resultInsertTask["success"] == 1){
                echo("rt:".$resultInsertTask["idTask"].": ");
                loadTodoTaskFromId($resultInsertTask["idTask"],$todo, $taskManager);
                break;
            }
        }
    }
}*/

/*foreach ($user->getListTodo() as $todo){
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
}*/

include "../view/home.php";