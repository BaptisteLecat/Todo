<?php

require_once '../../../../vendor/autoload.php';

use App\Model\Exceptions\PermissionException;
use App\Module\ModuleTaskManager;

try {
    $error = null;
    $task = null;
    
    $idTask = $_POST["idTask"];
    $idTodo = $_POST["idTodo"];

    $task = ModuleTaskManager::achieveTask($idTask, $idTodo);
} catch (PermissionException $e) {
    $error = $e->__toString();
}

$response = ["error" => $error, "task" => $task];
echo json_encode($response);
