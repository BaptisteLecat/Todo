<?php 

require_once '../../../../vendor/autoload.php';

session_start();

$user = unserialize($_SESSION["User"]);

$response = ["taskPourcent" => round($user->progressValuePercent())];

echo json_encode($response);