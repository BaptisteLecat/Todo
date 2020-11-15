<?php 

session_start();

$ses = unserialize($_SESSION["User"]);
var_dump($ses);

?>