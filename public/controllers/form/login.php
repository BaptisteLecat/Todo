<?php

use App\Model\Form\Sign\SignIn;

session_destroy();
session_start();


if (isset($_POST['email']) && isset($_POST['password'])) {
    $signIn = new SignIn($_POST["email"], $_POST["password"]);
}

include '../view/form/login.php';
