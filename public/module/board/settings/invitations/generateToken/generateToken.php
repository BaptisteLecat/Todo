<?php

require_once '../../../../../../vendor/autoload.php';

use App\Module\Settings\ModuleInvitations;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $success = null;
    $list_token = null;

    if (isset($_POST["idTodo"]) && !is_null($_POST["idTodo"])) {
        $idTodo = intval($_POST["idTodo"]);
    } else {
        throw new Exception("Cette todo n'existe pas.");
    }

    $list_token = ModuleInvitations::generateToken($idTodo);
    $success = new SuccessManager("Un nouveau token a été généré.", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "list_token" => $list_token];
echo json_encode($response);
