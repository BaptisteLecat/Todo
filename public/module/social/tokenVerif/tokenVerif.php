<?php

require_once '../../../../vendor/autoload.php';

use App\Module\Social\ModuleSocial;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\DatabaseException;

try {
    $messageBox = null;
    $success = null;
    $list_pendingContribute = null;

    if (isset($_POST["token"]) && !is_null($_POST["token"])) {
        $token = $_POST["token"];
        $list_pendingContribute = ModuleSocial::submitToken($token);
    } else {
        throw new Exception("Cette syntaxe semble incorrecte.");
    }


    $success = new SuccessManager("Votre demande est désormais en attente.", "success");
    $success = $success->__toString();
} catch (PDOException $e) {
    $messageBox = $e->__toString();
} catch (DatabaseException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "list_pendingContribute" => $list_pendingContribute];
echo json_encode($response);
