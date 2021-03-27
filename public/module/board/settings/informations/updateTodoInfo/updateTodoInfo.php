<?php

require_once '../../../../../../vendor/autoload.php';

use App\Module\Settings\ModuleInformations;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;

try {
    $messageBox = null;
    $success = null;
    $todo = null;
    $form_elements = array();

    $form_attributes = $_POST["form_attributes"]; //nom des inputs
    $form_values = $_POST["form_values"]; //valeur des inputs
    //Creation d'un tableau associatif de attribute => value.
    foreach ($form_attributes as $index => $attribute) {
        $form_elements[$attribute] = $form_values[$index];
    }

    $idTodo = $_POST["idTodo"];

    $todo = ModuleInformations::updateTodoInfo($idTodo, $form_elements);
    $success = new SuccessManager("La mise à jour des informations à réussie", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "todo" => $todo];
echo json_encode($response);
