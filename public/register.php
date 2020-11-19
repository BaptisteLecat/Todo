<?php

use App\Model\UserManager;

session_start();
require_once '../vendor/autoload.php';

if(isset($_POST["etape"])){
    $etape = $_POST["etape"];
}else{
    $etape = 1;
}

$name = "";
$firstName = "";
$user = new UserManager();

switch ($etape) {
    case 1: //Premier étape de la saisie, début.
        $flag = 0;
        if (isset($_POST['name']) || isset($_POST['firstname'])) {
            
            if($_POST["name"] != "" && $_POST["firstname"] != ""){
                if(preg_match("#[^a-zA-ZéÉèÈëËêÊàÀâÂäÄùÙûÛïÏîÎôÔöÖçÇ]#", $_POST["name"]) == 1){
                    $error = ["type" => "formatName", "message" => "Merci de saisir un Nom valide!"];
                    $flag = 1;
                    
                }else{
                    var_dump("coucou");
                }

                if(preg_match("#[^a-zA-ZéÉèÈëËêÊàÀâÂäÄùÙûÛïÏîÎôÔöÖçÇ]#", $_POST["firstname"]) == 1){
                    if($flag == 1){
                        $error = ["type" => "formatName_FirstName", "message" => "Merci de saisir un Nom et un Prénom valide!"];
                    }else{
                        $error = ["type" => "formatFirstName", "message" => "Merci de saisir un Prénom valide!"];
                        $flag = 1;
                    }
                }

                if($flag == 0){
                    $etape = 2;
                    
                }
            }else{
                $error = verifInput($etape);
            }
        }
        break;

    case 2:
        $flag = 0;
        if (isset($_POST['email']) || isset($_POST['password'])) {
            
            if($_POST["email"] != "" && $_POST["password"] != ""){
                    if(preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $_POST["email"]) == 0){
                    $error = ["type" => "formatEmail", "message" => "Email invalide!"];
                    $flag = 1;
                }

                if(preg_match("#^(?=.*[A-Za-z])(?=.*\d)(?=.*[&-+!*$@%_])([&-+!*$@%_\w]{8,25})$#", $_POST["password"]) == 0){
                    if($flag == 1){
                        $error = ["type" => "formatEmail_Password", "message" => "Email et Mot de Passe invalide!<br>Au moins 1 lettre, 1 chiffre, 1 caractère spécial et 8 caractères."];
                    }else{
                        $error = ["type" => "formatPassword", "message" => "Mot de Passe invalide!<br>Au moins 1 lettre, 1 chiffre, 1 caractère spécial et 8 caractères."];
                        $flag = 1;
                    }
                }

                if($flag == 0){
                    $etape = 1;
                    var_dump("ouai");
                }
            }else{
                $error = verifInput($etape);
            }
        }
    
    default:
        # code...
        break;
}


function verifInput($etape){
    $error = "";

    if($etape == 1){
        if($_POST["name"] == ""){
            $error = ["type" => "emptyName", "message" => "Merci de saisir un Nom!"];
        }else{
            if($_POST["firstname"] == ""){
                $error = ["type" => "emptyFirstName", "message" => "Merci de saisir un Prénom!"];
            }
        }
    }else{
        if($_POST["email"] == ""){
            $error = ["type" => "emptyEmail", "message" => "Merci de saisir un Email!"];
        }else{
            if($_POST["password"] == ""){
                $error = ["type" => "emptyPassword", "message" => "Merci de saisir un Mot de Passe!"];
            }
        }
    }

    return $error;
}

include "../view/register.php";
