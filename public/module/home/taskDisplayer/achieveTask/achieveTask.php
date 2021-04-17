<?php

require_once '../../../../../vendor/autoload.php';

use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;
use App\Module\Home\ModuleHome;

try {
    $messageBox = null;
    $success = null;
    $todoObject = null;

    if (isset($_POST["idTask"]) && !is_null($_POST["idTask"])) {
        $idTask = intval($_POST["idTask"]);
    } else {
        throw new Exception("Cette tâche n'existe pas.");
    }

    $todoObject = ModuleHome::achieveTask($idTask);

    $success = new SuccessManager("L' état de la tâche a été modifié.", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "list_task" => $todoObject->getList_Task(), "taskPourcent" => $todoObject->progressValuePercent()];
echo json_encode($response);