<?php
include '../modele/autoloader.php'; Autoloader::register();
$connexion = new accesBD();
$response = ["connexion" => serialize($connexion)];
echo json_encode($response);

 ?>
