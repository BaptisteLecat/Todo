<?php

require_once '../../../../../../vendor/autoload.php';

use App\Module\Settings\ModuleInvitations;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $success = null;
    $list_token = null;

    if (isset($_POST["token"])) {
        $token = $_POST["token"];
    } else {
        throw new Exception("Ce token n'existe pas.");
    }

    if (is_null($token)) {
        throw new Exception("Ce token n'existe pas.");
    }

    $list_token = ModuleInvitations::regenerateToken($token);
    $success = new SuccessManager("Le token a bien été régénéré.", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "list_token" => $list_token];
echo json_encode($response);
