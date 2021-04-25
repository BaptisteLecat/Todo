<?php

require_once '../../../../../vendor/autoload.php';

use App\Model\Exceptions\TaskDisplayerException;
use App\Model\Utils\DateFrench;
use App\Module\Home\ModuleHome;

try {
    $messageBox = null;
    $success = null;
    $taskForToday = null;
    $taskPourcentToday = null;
    $globalTaskPourcent = null;

    if (isset($_POST["dayIndex"]) && !is_null($_POST["dayIndex"])) {
        $dayIndex = intval($_POST["dayIndex"]);
    } else {
        throw new Exception("Cette tâche n'existe pas.");
    }

    //Verification de la valeur de dayIndex. -3 to +3
    if($dayIndex > 3 || $dayIndex < -3){
        throw new TaskDisplayerException(1);
    }

    $dateSet = DateFrench::dateFromIndex($dayIndex);

    $taskForToday = ModuleHome::taskForToday(ModuleHome::getUserObject()->getList_Task(), $dateSet);
    $taskPourcentToday = ModuleHome::progressValuePercentToday($taskForToday);
    $globalTaskPourcent = ModuleHome::getUserObject()->progressValuePercent();
} catch (Exception $e) {
    throw new Exception($e);
}

$response = ["messageBox" => $messageBox, "success" => $success, "taskForToday" => $taskForToday, "taskPourcentToday" => $taskPourcentToday, "globalTaskPourcent" => $globalTaskPourcent, "dateSet" => DateFrench::dateToString($dateSet)];
echo json_encode($response);
