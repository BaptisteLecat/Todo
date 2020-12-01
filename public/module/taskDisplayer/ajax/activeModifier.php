<?php

require_once '../../../../vendor/autoload.php';

use App\Model\TaskManager;

session_start();

$idTask = $_POST["idTask"];

function activeStateModifier($idTask){
    $user = unserialize($_SESSION["User"]);
    foreach ($user->getListTask() as $task) {
        if ($task->getId() == $idTask) {
            $taskManager = new TaskManager();
            if ($task->getActive() == 1) {
                $taskManager->updateTask($task, "active", 0);
            } else {
                $taskManager->updateTask($task, "active", 1);
            }
            $_SESSION["User"] = serialize($user);
            break;
        }
    }
    return $task;
}

echo json_encode(activeStateModifier($idTask));
