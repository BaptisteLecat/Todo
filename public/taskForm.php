<?php 

require_once '../vendor/autoload.php';
require 'module/taskDisplayer/function/dayDisplayer.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\Utils\MessageBox;
use App\Model\Entity\DateFrench;

session_start();

if(!isset($_SESSION["User"])){
    header("Location: login.php");
}

$user = unserialize($_SESSION["User"]);
$todoManager = new TodoManager();
$taskManager = new TaskManager();
$messageBox = null;

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

if(isset($_POST["todo-selector"])){
    if($_POST["date"] == ""){
        $date = date('Y-m-d');
    }else{
        $date = $_POST["date"];
    }
    foreach($user->getListTodo() as $todo){
        
        if($todo->getId() == $_POST["todo-selector"]){
            $resultInsertTask = $taskManager->insertTask($_POST["content"], $date, $_POST["time"], $todo);
            
            if($resultInsertTask["success"] == 1){
                $messageBox = new MessageBox("Félicitation, vous avez désormais une tâche supplémentaire à effectuer !", "validate");
            }else{
                $messageBox = new MessageBox("Ohoh, il semblerait qu'un problème soit survenue !", "error");
            }
            break;
        }
    }
}

include("../view/taskForm.php");