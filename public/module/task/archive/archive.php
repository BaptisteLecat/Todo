<?php

require_once '../../../../vendor/autoload.php';

use App\Module\ModuleTaskManager;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $success = null;

    $list_idTask = json_decode($_POST["list_idTask"], true);
    $idTodo = $_POST["idTodo"];

    ModuleTaskManager::archiveTask($list_idTask, $idTodo);
    $success = new SuccessManager("L'archivage s'est effectué avec succès.", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success];
echo json_encode($response);
