<?php
require_once '../../../../../../vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Model\Entity\Permission;
use App\Module\Settings\ModuleInformations;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $success = null;
    $idTodo = null;
    $right = array();
    $contributorObject = null;

    $right = $_POST["idPermission"];

    $idContributor = $_POST["idContributor"]; //valeur des inputs
    $idTodo = $_POST["idTodo"];

    $contributorObject = ModuleInformations::updateUserRight($idTodo, intval($idContributor), $right);
    $success = new SuccessManager("La mise à jour des permissions à réussie", "success");
    $success = $success->__toString();
    //TODO retourner les list des permission pour actualiser la page.
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}
$response = ["messageBox" => $messageBox, "success" => $success, "contributorObject" => $contributorObject];
echo json_encode($response);
