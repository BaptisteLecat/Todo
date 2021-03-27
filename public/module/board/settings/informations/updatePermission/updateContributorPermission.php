<?php

require_once '../../../../../../vendor/autoload.php';

use App\Module\Settings\ModuleInformations;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $success = null;
    $todo = null;
    $right = array();

    $right = $_POST["idPermission"];
    $idContributor = $_POST["idContributor"]; //valeur des inputs

    $idTodo = $_POST["idTodo"];

    $givedPermission = ModuleInformations::updateUserRight($idTodo, intval($idContributor), $right);
    $success = new SuccessManager("La mise à jour des permissions à réussie", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Error $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "givedPermission" => $givedPermission];
echo json_encode($response);
