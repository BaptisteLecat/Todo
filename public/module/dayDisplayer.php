<?php 

function taskForToday($user){
    $listTaskToday = array();
    foreach($user->getListTask() as $task){
        //if($task->getEndDate() == date("Y-m-d")){
            if($task->getActive() == 1){
                array_push($listTaskToday, $task);
            }
        //}
    }
    return $listTaskToday;
}

function nbTaskValidate($listTask){
    $nbTaskValidate = 0;
    foreach($listTask as $task){
        if($task->getActive() == 1){
            $nbTaskValidate++;
        }
    }
    return $nbTaskValidate;
}