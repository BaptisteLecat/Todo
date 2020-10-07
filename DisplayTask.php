<?php

require 'modele/class_todo.php';
require 'modele/class_task.php';

$today_todo = new Todo(1, "Today");
$tomorrow_todo = new Todo(2, "Tomorrow");

/*$d1 = new DateTime();
$d1 = $d1->format('Y-m-d');
$d2 = new DateTime('2020-06-10');
$diff = $d1->diff($d2);
$nb_jours = $diff->days;*/

$task1_date = strtotime("15:30pm October 15 2014");
$task1 = new Task(1, "Faire les devoirs", $task1_date, 1, $today_todo);
$task2_date = strtotime("15:30pm October 15 2014");
$task2 = new Task(2, "Aller chercher les enfants", date("Y-m-d h:i:sa",$task2_date), 1, $today_todo);
$task3_date = strtotime("15:30pm October 15 2014");
$task3 = new Task(3, "Récupérer les cours", date("Y-m-d h:i:sa",$task3_date), 0, $today_todo);
$task4_date = strtotime("15:30pm October 15 2014");
$task4 = new Task(4, "Faire les crêpes", date("Y-m-d h:i:sa",$task4_date), 1, $tomorrow_todo);

var_dump($today_todo->GET_ListeTask());

/*foreach ($today_todo->GET_ListeTask() as $key => $value) {
  if ($value->GET_Statut() == 1) {
    echo '<div class="task_container">
      <div class="task_content_validate">
        <h6>'.$value->GET_Content().'</h6>
        <div class="task_validate">
          <img class="validate_icon" src="assets\icons\checkmark_52px.png" alt="validate icon">
        </div>
      </div>
      <img class="bin_icon" src="assets\icons\trash_52px.png" alt="bin to delete">
    </div>';
  }else {
    // code...
  }
}*/




 ?>
