<?php 

/**
 * Utilisé lors du chargement de la page par le Controleur, pour afficher les tâches du Jour.
 */

function taskForToday($list_task){
    $listTaskToday = array();
    foreach($list_task as $task){
        if($task->getEndDate() == date("Y-m-d")){
            array_push($listTaskToday, $task);
        }
    }
    return $listTaskToday;
}

function nbTaskValidate($listTask){
    $nbTaskValidate = 0;
    foreach($listTask as $task){
        if($task->isAchieve() == 1){
            $nbTaskValidate++;
        }
    }
    return $nbTaskValidate;
}