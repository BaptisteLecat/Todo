<?php

require 'modele/class_todo.php';
require 'modele/class_task.php';

$today_todo = new Todo(1, "Today");
$tomorrow_todo = new Todo(2, "Tomorrow");

$task1_date = strtotime("15:30pm October 15 2014");
$task1 = new Task(1, "Faire les devoirs", date("Y-m-d h:i:sa",$task1_date), 1, $today_todo);
$task2_date = strtotime("15:30pm October 15 2014");
$task2 = new Task(1, "Aller chercher les enfants", date("Y-m-d h:i:sa",$task2_date), 1, $today_todo);
$task3_date = strtotime("15:30pm October 15 2014");
$task3 = new Task(1, "Récupérer les cours", date("Y-m-d h:i:sa",$task3_date), 0, $today_todo);
$task4_date = strtotime("15:30pm October 15 2014");
$task4 = new Task(1, "Faire les crêpes", date("Y-m-d h:i:sa",$task4_date), 1, $tomorrow_todo);

var_dump($today_todo);
 ?>
