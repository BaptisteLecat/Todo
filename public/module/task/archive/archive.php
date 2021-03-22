<?php

require_once '../../../../vendor/autoload.php';

use App\Module\ModuleTaskManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $task = null;

    $list_idTask = json_decode($_POST["list_idTask"], true);
    $idTodo = $_POST["idTodo"];

    $task = ModuleTaskManager::archiveTask($list_idTask, $idTodo);
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
}

$response = ["messageBox" => $messageBox, "task" => $task];
echo json_encode($response);
