<?php

use App\Model\UserManager;

session_destroy();
session_start();


if (isset($_POST['email']) && isset($_POST['password'])) {
    $error = login();
}


function verifInput(){
    $error = "";

    if($_POST["email"] == ""){
        $error = ["type" => "emptyEmail", "message" => "Merci de saisir une email!"];
    }else{
        if($_POST["password"] == ""){
            $error = ["type" => "emptyPassword", "message" => "Merci de saisir un Mot de passe!"];
        }
    }

    return $error;
}

function login(){
    $error = "";
    try{
        if ($_POST["email"] != "" && $_POST["password"] != "") {
            if (preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $_POST["email"])) {
                $resultVerifLogin = UserManager::verifLogin($_POST['email'], $_POST['password']);
                if ($resultVerifLogin ==! null) {
                    $_SESSION["User"] = serialize(UserManager::loadUser($resultVerifLogin));
                    header("Location: home");
                } else {
                    $error = ["type" => "login", "message" => "Identifiant ou Mot de passe incorrect!"];
                }
            } else {
                $error = ["type" => "email", "message" => "Format de l'email incorrect!"];
            }
        } else {
            $error = verifInput();
        }
    }catch(Exception $e){
        throw new Exception($e);
    }

    return $error;
}

include '../view/form/login.php';
