<?php

session_start();
session_destroy();
session_start();

require_once '../vendor/autoload.php';

use App\Model\UserManager;

$userManager = new UserManager();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $error = login($userManager);
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

function login($userObject){
    $error = "";
    if($_POST["email"] != "" && $_POST["password"] != ""){
        if (preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $_POST["email"])) {
            $resultVerifLogin = $userObject->verifLogin($_POST['email'], $_POST['password']);
            if ($resultVerifLogin["success"] == 1) {
                $resultLoadUser = $userObject->loadUser($resultVerifLogin["id_user"]);
                if($resultLoadUser["success"] == 1){
                    $_SESSION["User"] = serialize($resultLoadUser["userObject"]);
                    header("Location: home.php");
                } 
            } else {
                $error = ["type" => "login", "message" => "Identifiant ou Mot de passe incorrect!"];
            }
        } else {
            $error = ["type" => "email", "message" => "Format de l'email incorrect!"];
        }
    
    }else{
        $error = verifInput();
    }

    return $error;
}

include '../view/form/login.php';
