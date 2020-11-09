<?php

include("accesBD.php");

$connection = new accesBD();
var_dump($connection->REQUser_VerifLogin("baptiste.lecat44@gmail.com", "baptiste"));

 ?>
