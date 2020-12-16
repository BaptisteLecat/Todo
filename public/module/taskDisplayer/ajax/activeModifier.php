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
                $taskManager->updateActive($task, 0);
            } else {
                $taskManager->updateActive($task, 1);
            }
            $_SESSION["User"] = serialize($user);
            break;
        }
    }
    return $task;
}

echo json_encode(activeStateModifier($idTask));
