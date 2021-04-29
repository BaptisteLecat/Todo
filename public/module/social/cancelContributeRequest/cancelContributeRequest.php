<?php

require_once '../../../../vendor/autoload.php';

use App\Module\Social\ModuleSocial;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\DatabaseException;

try {
    $messageBox = null;
    $success = null;
    $list_pendingContribute = null;

    if (isset($_POST["idTodo"]) && !is_null($_POST["idTodo"])) {
        $idTodo = $_POST["idTodo"];
        $list_pendingContribute = ModuleSocial::cancelContributeRequest($idTodo);
    } else {
        throw new Exception("Cette todo n'existe pas.");
    }


    $success = new SuccessManager("Votre demande à été annulé.", "success");
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
