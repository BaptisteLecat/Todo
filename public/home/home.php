<?php
require 'module/taskDisplayer/function/dayDisplayer.php';

use App\Model\Utils\DateFrench;
use App\Model\Utils\Calendar;

$taskForToday = taskForToday($this->user);
$nbTaskValidate = nbTaskValidate($taskForToday);
$dayTitle = dateFrench::dateToDay(strtotime(date('Y-m-d')));
$dateString = dateFrench::dateToString(strtotime(date('Y-m-d')));
/*
Si l'on souhaite afficher une date précise.
$getdate = getdate();
$test = date("Y-m-d", mktime(0, 0, 0, 1, 1, $getdate["year"]));

$date = new \DateTime($test);
$calendar = new Calendar($date->format("U"), $user);*/

$calendar = new Calendar(null, $this->user);

include "../view/home.php";
