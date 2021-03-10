<?php

require_once '../../../../vendor/autoload.php';

use App\Model\TaskManager;

session_start();

$idTask = $_POST["idTask"];

function achieveTask($idTask)
{
    try {
        $taskObject = null;
        $user = unserialize($_SESSION["User"]);
        foreach ($user->getList_Task() as $task) {
            if ($task->getId() == $idTask) {
                TaskManager::achieveTask($user, $task);
                $taskObject = $task;
                $_SESSION["User"] = serialize($user);
                break;
            }
        }
        return $taskObject;
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

echo json_encode(achieveTask($idTask));
