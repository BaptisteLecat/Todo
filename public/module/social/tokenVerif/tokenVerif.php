<?php

require_once '../../../../vendor/autoload.php';

use App\Module\Social\ModuleSocial;
use App\Model\Exceptions\MessageBox;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\DatabaseException;

try {
    $messageBox = null;
    $success = null;

    if (isset($_POST["token"]) && !is_null($_POST["token"])) {
        $token = $_POST["token"];
    } else {
        throw new Exception("Cette syntaxe semble incorrecte.");
    }

    ModuleSocial::submitToken($token);

    $success = new SuccessManager("Le token est valide.", "success");
    $success = $success->__toString();
} catch (PDOException $e) {
    $messageBox = $e->__toString();
} catch (DatabaseException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success];
echo json_encode($response);
