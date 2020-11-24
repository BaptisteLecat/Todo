<?php 

include '../vendor/autoload.php';

use App\Model\TaskManager;
use App\Model\Entity\Task;
use App\Model\Entity\User;

$taskManager = $_POST["taskManager"];
$user = $_POST["userObject"];

function taskForToday($user){
    $listTaskToday = array();
    foreach($user->getListTask() as $task){
        if($task->getEndDate() == date("Y-m-d")){
            if($task->getActive() == 1){
                array_push($listTaskToday, $task);
            }
        }
    }
    return $listTaskToday;
}
$response = ["i" => 1];
echo json_encode($user);