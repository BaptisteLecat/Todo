<?php 

require_once '../../../../vendor/autoload.php';

session_start();

$user = unserialize($_SESSION["User"]);

$response = ["taskPourcent" => round($user->progressValuePourcent())];

echo json_encode($response);