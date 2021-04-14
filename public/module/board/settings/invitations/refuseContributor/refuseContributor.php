<?php

require_once '../../../../../../vendor/autoload.php';

use App\Module\Settings\ModuleInvitations;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $success = null;
    $list_invitation = null;

    if (isset($_POST["idContributor"]) && !is_null($_POST["idContributor"])) {
        $idContributor = intval($_POST["idContributor"]);
    } else {
        throw new Exception("Ce participant n'existe pas.");
    }

    if (isset($_POST["idTodo"]) && !is_null($_POST["idTodo"])) {
        $idTodo = intval($_POST["idTodo"]);
    } else {
        throw new Exception("Cette todo n'existe pas.");
    }

    $list_invitation = ModuleInvitations::refuseContributor($idContributor, $idTodo);
    $success = new SuccessManager("La demande de participation a été refusé.", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "list_invitation" => $list_invitation];
echo json_encode($response);
