<?php 
session_start();

require_once '../vendor/autoload.php';

if(!isset($_SESSION['User'])){
    header("Location: login.php");
}else{
    header("Location: home.php");
}

?>