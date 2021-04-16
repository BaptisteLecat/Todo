<?php

//require_once '../../../../../vendor/autoload.php';

echo("coucou");
/*use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;
use App\Module\Settings\ModuleHome;

try {
    $messageBox = null;
    $success = null;
    $list_token = null;

    if (isset($_POST["idTask"]) && !is_null($_POST["idTask"])) {
        $idContributor = intval($_POST["idTask"]);
    } else {
        throw new Exception("Cette tâche n'existe pas.");
    }

    if (isset($_POST["idTodo"]) && !is_null($_POST["idTodo"])) {
        $idTodo = intval($_POST["idTodo"]);
    } else {
        throw new Exception("Cette todo n'existe pas.");
    }

    $task = ModuleHome::achieveTask($idTask, $idTodo);
    $success = new SuccessManager("L'état de la tâche a été modifié.", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "task" => $task];
echo json_encode($response);*/
