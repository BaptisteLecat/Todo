<?php 
require_once '../../vendor/autoload.php';

use App\Model\Entity\Task;
use App\Model\Entity\Todo;

session_start();

function taskForToday(){
    $user = unserialize($_SESSION["User"]);
    $listTaskToday = array();
    foreach($user->getListTask() as $task){
        if($task->getEndDate() == date("Y-m-d")){
            array_push($listTaskToday, $task);
        }
    }
    return $listTaskToday;
}
//var_dump(unserialize($_SESSION["User"]));
//$todo = new Todo(5, "rtrt", 5, "private", "19/20/1", unserialize($_SESSION["User"]));
//$task = new Task(5, "Hello guy", "78", "e", 8, $todo, unserialize($_SESSION["User"]));
//var_dump($task);
//$tab = ["coucou" => "salut", "prenom" => "hénry"];

echo json_encode(taskForToday());