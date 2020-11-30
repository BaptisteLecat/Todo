<?php 

require_once '../vendor/autoload.php';
require 'module/dayDisplayer.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\Entity\DateFrench;

session_start();

if(!isset($_SESSION["User"])){
    header("Location: login.php");
}

$user = unserialize($_SESSION["User"]);
$todoManager = new TodoManager();
$taskManager = new TaskManager();

//Permet de recharger la liste de task et de Todo sans avoir de doublon.
if($user->getListTask() != null){
    $user->setListTask(array());
}

if($user->getListTodo() != null){
    $user->setListTodo(array());
}

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
$dayTitle = dateFrench::dateToDay(strtotime(date('Y-m-d')));
$dateString= dateFrench::dateToString(strtotime(date('Y-m-d')));

//var_dump(unserialize($_SESSION["User"]));


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