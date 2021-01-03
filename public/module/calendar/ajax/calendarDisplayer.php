<?php

require_once '../vendor/autoload.php';

use App\Model\Utils\Calendar;

session_start();

$user = unserialize($_SESSION["User"]);
$month_index = $_POST["month"];

$current_date = getdate();
$date = date("Y-m-d", mktime(0, 0, 0, 1 + $month_index, null, $current_date["year"]));

$dateTime = new \DateTime($date);
$calendar = new Calendar($dateTime->format("U"), $user);

$response = ["calendar" => $calendar->calendarDisplayer()];