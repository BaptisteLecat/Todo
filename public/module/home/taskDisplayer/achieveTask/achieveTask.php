<?php

require_once '../../../../../vendor/autoload.php';

use App\Model\Utils\DateFrench;
use App\Module\Home\ModuleHome;
use App\Model\Exceptions\SuccessManager;
use App\Model\Exceptions\PermissionException;
use App\Model\Exceptions\TaskDisplayerException;

try {
    $messageBox = null;
    $success = null;
    $taskForToday = null;
    $taskPourcentToday = null;
    $globalTaskPourcent = null;

    if (isset($_POST["idTask"]) && !is_null($_POST["idTask"])) {
        $idTask = intval($_POST["idTask"]);
    } else {
        throw new Exception("Cette tâche n'existe pas.");
    }

    if (isset($_POST["dayIndex"]) && !is_null($_POST["dayIndex"])) {
        $dayIndex = intval($_POST["dayIndex"]);
    } else {
        throw new Exception("Ce jour n'existe pas.");
    }

    //Verification de la valeur de dayIndex. -3 to +3
    if ($dayIndex > 3 || $dayIndex < -3) {
        throw new TaskDisplayerException(1);
    }

    $dateSet = DateFrench::dateFromIndex($dayIndex);

    ModuleHome::achieveTask($idTask);
    $taskForToday = ModuleHome::taskForToday(ModuleHome::getUserObject()->getList_Task(), $dateSet);
    $taskPourcentToday = ModuleHome::progressValuePercentToday($taskForToday);
    $globalTaskPourcent = ModuleHome::getUserObject()->progressValuePercent();

    $success = new SuccessManager("L' état de la tâche a été modifié.", "success");
    $success = $success->__toString();
} catch (PermissionException $e) {
    $messageBox = $e->__toString();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "taskForToday" => $taskForToday, "taskPourcentToday" => $taskPourcentToday, "globalTaskPourcent" => $globalTaskPourcent];
echo json_encode($response);