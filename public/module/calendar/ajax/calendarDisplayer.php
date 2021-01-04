<?php

require_once '../../../../vendor/autoload.php';

use App\Model\Utils\Calendar;

session_start();

$user = unserialize($_SESSION["User"]);
$month_index = $_POST["month"];

$current_date = getdate();
//Si month index est positif ou négatif on avancera ou reculera d'un mois.
$date = date("Y-m-d", mktime(0, 0, 0, $current_date["mon"] + $month_index, $current_date["mday"], $current_date["year"]));

$dateTime = new \DateTime($date);
$calendar = new Calendar($dateTime->format("U"), $user);

$response = ["calendarHTML" => $calendar->calendarDisplayer(), "calendarMonth" => $calendar->getMonth(), "calendarYear" => $calendar->getYear()];

echo json_encode($response);