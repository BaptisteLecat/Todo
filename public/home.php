<?php

require_once '../vendor/autoload.php';
require 'module/taskDisplayer/function/dayDisplayer.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\TodoIconManager;
use App\Model\Utils\DateFrench;
use App\Model\Utils\Calendar;

session_start();

if (!isset($_SESSION["User"])) {
    header("Location: login.php");
}

$user = unserialize($_SESSION["User"]);
$todoManager = new TodoManager();
$todoIconManager = new TodoIconManager();
$taskManager = new TaskManager();

//Permet de recharger la liste de task et de Todo sans avoir de doublon.
if ($user->getListTask() != null) {
    $user->setListTask(array());
}

if ($user->getListTodo() != null) {
    $user->setListTodo(array());
}

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

loadUserTodo($user, $todoManager, $todoIconManager);
loadUserTask($user, $taskManager);
$_SESSION["User"] = serialize($user);
$taskForToday = taskForToday($user);
$nbTaskValidate = nbTaskValidate($taskForToday);
$dayTitle = dateFrench::dateToDay(strtotime(date('Y-m-d')));
$dateString = dateFrench::dateToString(strtotime(date('Y-m-d')));
/*
Si l'on souhaite afficher une date précise.
$getdate = getdate();
$test = date("Y-m-d", mktime(0, 0, 0, 1, 1, $getdate["year"]));

$date = new \DateTime($test);
$calendar = new Calendar($date->format("U"), $user);*/

$calendar = new Calendar(null, $user);

include "../view/home.php";
