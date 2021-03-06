<?php 

/**
 * Utilisé lors des appels AJAX pour effectuer le chargement des taches pour un jour donné.
 */

require_once '../../../../vendor/autoload.php';

use App\Model\Utils\DateFrench;

session_start();

$dayIndex = $_POST["day"];
$dateDefine = DateFrench::dateFromIndex($dayIndex);

function taskForToday($dateDefine){
    $user = unserialize($_SESSION["User"]);
    $listTaskToday = array();
    foreach($user->getList_Task() as $task){
        if($task->getEndDate() == $dateDefine){
            array_push($listTaskToday, $task);
        }
    }
    return $listTaskToday;
}

$response = ["dayTitle" => dateFrench::dateToDay(strtotime($dateDefine)), "dateString" => dateFrench::dateToString(strtotime($dateDefine)), "listTask" => taskForToday($dateDefine)];

echo json_encode($response);