<?php

/**
 * Utilisé lors des appels AJAX pour supprimer une task par rapport à son id.
 */

require_once '../../../../vendor/autoload.php';

use App\Model\TaskManager;

session_start();

$idTask = $_POST["idTask"];

function deleteTask($idTask)
{
    $response = ["success" => 0];
    $user = unserialize($_SESSION["User"]);
    foreach ($user->getListTask() as $task) {
        if ($task->getId() == $idTask) {
            $taskManager = new TaskManager();
            //if ($taskManager->deleteTask($task)["success"] == 1) {
                $response = "coucou";
                $_SESSION["User"] = serialize($user);
                break;
            //}
        }
    }
    return $response;
}

echo json_encode(deleteTask($idTask));
