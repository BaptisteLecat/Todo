<?php

require_once '../vendor/autoload.php';
require 'module/taskDisplayer/function/dayDisplayer.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\Utils\MessageBox;
use App\Model\Utils\DateFrench;

session_start();

if (!isset($_SESSION["User"])) {
    header("Location: login.php");
}

$user = unserialize($_SESSION["User"]);
//Permet de recharger la liste de task et de Todo sans avoir de doublon.
if ($user->getListTask() != null) {
    $user->setListTask(array());
}

if ($user->getListTodo() != null) {
    $user->setListTodo(array());
}
$todoManager = new TodoManager();
$taskManager = new TaskManager();
loadUserTodo($user, $todoManager);
loadUserTask($user, $taskManager);
$_SESSION["User"] = serialize($user);

if (isset($_GET["form"])) {
    switch ($_GET["form"]) {
        case "CreateTask":
            $messageBox = null;
            if (isset($_POST["todo-selector"])) { //Si le formulaire a été soumis.
                $errorId = true; //Variable permettant de verifier que l'id du todo-selector existe bien.
                foreach ($user->getListTodo() as $todo) {

                    if ($todo->getId() == $_POST["todo-selector"]) { //L'id est valide.
                        $errorId = false;
                        $resultInsertTask = $taskManager->insertTask($_POST["content"], $_POST["date"], $_POST["time"], $todo);

                        //Affichage de la messageBox success ou error.
                        if ($resultInsertTask["success"] == 1) {
                            $messageBox = new MessageBox("Félicitation, vous avez désormais une tâche supplémentaire à effectuer !", "validate");
                        } else {
                            $messageBox = new MessageBox("Ohoh, il semblerait qu'un problème soit survenue !", "error");
                        }
                        break;
                    }
                }

                //L'id du todo-selector n'existe pas.
                if ($errorId == true) {
                    $messageBox = new MessageBox("Ohoh, le Todo sélectionné est inconnu !", "error");
                }
            }
            include("../view/form/taskCreate.php");
            break;

        case "CreateTodo":
            $messageBox = null;
            if (isset($_POST["title"])) {
                $resultNbTodo = $todoManager->countTodoRow($user->getId());
                if ($resultNbTodo["nbrow"] < 5) {
                    $resultInsertTodo = $todoManager->insertTodo($_POST["title"], $_POST["description"], $_POST["status"], $_POST["date"], $_POST["time"], $user);
                    //Affichage de la messageBox success ou error.
                    if ($resultInsertTodo["success"] == 1) {
                        $messageBox = new MessageBox("Félicitation, vous avez désormais une tâche supplémentaire à effectuer !", "validate");
                    } else {
                        $messageBox = new MessageBox("Ohoh, il semblerait qu'un problème soit survenue !", "error");
                    }
                } else {
                    $messageBox = new MessageBox("Désole, vous avez atteint le nombre maximum de Todo ! Veuillez en supprimer et recommencer.", "error");
                }
            }
            include("../view/form/todoCreate.php");
            break;
    }
} else {
    $messageBox = null;
    if (isset($_POST["todo-selector"])) { //Si le formulaire a été soumis.
        $date = $_POST["date"];
        $errorId = true; //Variable permettant de verifier que l'id du todo-selector existe bien.
        foreach ($user->getListTodo() as $todo) {

            if ($todo->getId() == $_POST["todo-selector"]) { //L'id est valide.
                $errorId = false;
                $resultInsertTask = $taskManager->insertTask($_POST["content"], $date, $_POST["time"], $todo);

                //Affichage de la messageBox success ou error.
                if ($resultInsertTask["success"] == 1) {
                    $messageBox = new MessageBox("Félicitation, vous avez désormais une tâche supplémentaire à effectuer !", "validate");
                } else {
                    $messageBox = new MessageBox("Ohoh, il semblerait qu'un problème soit survenue !", "error");
                }
                break;
            }
        }

        //L'id du todo-selector n'existe pas.
        if ($errorId == true) {
            $messageBox = new MessageBox("Ohoh, le Todo sélectionné est inconnu !", "error");
        }
    }
    include("../view/form/taskCreate.php");
}

function loadUserTodo($user, $todoManager)
{
    $resultLoadTodo = $todoManager->loadTodoFromUserObject($user);
    if ($resultLoadTodo["success"] == 1) {
        //Success.
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
