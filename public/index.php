<?php 
session_start();

require_once '../vendor/autoload.php';

if(!isset($_SESSION['AUTH'])){
    header("Location: login.php");
}



include '../view/home.php';

?>