<?php

include '../modele/autoloader.php'; Autoloader::register();
$connexion = unserialize($_POST["connexion"]);
$restest = $connexion->REQUser_VerifEmail("baptiste.lecat44@gmail.com");

$response = ["restest" => $restest];

echo json_encode($response);

 ?>
