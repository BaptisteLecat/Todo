<?php 
require_once '../../vendor/autoload.php';

use App\Model\Entity\Task;

session_start();

function taskForToday(){
    $user = unserialize($_SESSION["User"]);
    //$listTaskToday = array();
    foreach($user->getListTask() as $task){
        if($task->getEndDate() == date("Y-m-d")){
            if($task->getActive() == 1){
                $listTaskToday = $task;
            }
        }
    }
    return $listTaskToday;
}

$task = new Task("5", "Hello guy", "78", "e", 8, null, null);

echo json_encode($task);