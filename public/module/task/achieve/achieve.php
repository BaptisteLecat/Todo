<?php

require_once '../../../../vendor/autoload.php';

use App\Model\Exceptions\PermissionException;
use App\Module\Todo\ModuleTaskManager;

try {
    $messageBox = null;
    $task = null;

    $idTask = $_POST["idTask"];
    $idTodo = $_POST["idTodo"];

    $task = ModuleTaskManager::achieveTask($idTask, $idTodo);
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
}

$response = ["messageBox" => $messageBox, "task" => $task];
echo json_encode($response);
