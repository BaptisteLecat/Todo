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
$task1 = new Task(1, "Faire les devoirs", $task1_date, false, $today_todo);
$task2_date = strtotime("15:30pm October 15 2014");
$task2 = new Task(2, "Aller chercher les enfants", date("Y-m-d h:i:sa",$task2_date), false, $today_todo);
$task3_date = strtotime("15:30pm October 15 2014");
$task3 = new Task(3, "Récupérer les cours", date("Y-m-d h:i:sa",$task3_date), false, $today_todo);
$task4_date = strtotime("15:30pm October 15 2014");
$task4 = new Task(4, "Faire les crêpes", date("Y-m-d h:i:sa",$task4_date), true, $tomorrow_todo);
$today_todo->RemoveTask(2);

echo '<div class="todo_container">

  <div class="todo_header">
    <h1>'.$today_todo->GET_Title().'</h1>
    <div class="progressBar_container">
      <div class="progressBar_bar" style=" width:'.$today_todo->GET_ProgressValuePourcent().'%;">
      </div>
    </div>
    <div class="taskInfo_container">
      <h3>'.$today_todo->GET_NbTaskValidate().' / '.count($today_todo->GET_ListeTask()).'</h3>
    </div>
  </div>

  <div class="todo_content">';

foreach ($today_todo->GET_ListeTask() as $key => $value) {
  if ($value->GET_Statut()) {
    echo '        <div class="task_container">
              <div class="task_content_validate">
                <div class="task_title">
                  <h6>'.$value->GET_Content().'</h6>
                  <p>14 Juillet 2020</p>
                </div>
                <div class="task_validate">
                  <img class="validate_icon" src="assets\icons\checkmark_52px.png" alt="validate icon">
                </div>
              </div>
              <img class="bin_icon" src="assets\icons\trash_52px.png" alt="bin to delete">
            </div>';
  }else {
    echo '<div class="task_container">
      <div class="task_content_todo" onclick="DisplayInfo(this);">
      <div class="task_title">
        <h6>'.$value->GET_Content().'</h6>
        <p>14 Juillet 2020</p>
      </div>
        <div class="task_todo">
        </div>
      </div>
      <img class="bin_icon" src="assets\icons\trash_52px.png" alt="bin to delete">
    </div>';
  }
}

echo '<button type="button" name="AddTask" class="btn_addClass"><h1>+</h1></button></div>
    </div>';




 ?>
