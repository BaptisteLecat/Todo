<?php

use App\Model\UserManager;

session_start();
require_once '../vendor/autoload.php';

$etape = 0;
$name = "";
$firstName = "";
$user = new UserManager();

switch ($etape) {
    case 0: //Premier étape de la saisie, début.
        $flag = 0;
        if (isset($_POST['name']) || isset($_POST['firstname'])) {
            
            if($_POST["name"] != "" && $_POST["firstname"] != ""){
                var_dump($_POST["name"], $_POST["firstname"]);
                if(preg_match("#[^a-zA-ZéÉèÈëËêÊàÀâÂäÄùÙûÛïÏîÎôÔöÖçÇ]#", $_POST["name"]) == 1){
                    $error = ["type" => "formatName", "message" => "Merci de saisir un Nom valide!"];
                    $flag = 1;
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
                $error = verifInput($flag);
            }
        }
        break;

    case 2:
        $flag = 0;
        if (isset($_POST['email']) || isset($_POST['password'])) {
            
            if($_POST["email"] != "" && $_POST["password"] != ""){
                var_dump($_POST["email"], $_POST["password"]);
                    if(preg_match("#[^a-zA-ZéÉèÈëËêÊàÀâÂäÄùÙûÛïÏîÎôÔöÖçÇ]#", $_POST["email"]) == 1){
                    $error = ["type" => "formatEmail", "message" => "Merci de saisir une Email valide!"];
                    $flag = 1;
                }

                if(preg_match("#[^a-zA-ZéÉèÈëËêÊàÀâÂäÄùÙûÛïÏîÎôÔöÖçÇ]#", $_POST["password"]) == 1){
                    if($flag == 1){
                        $error = ["type" => "formatEmail_Password", "message" => "Merci de saisir une Email et un Mot de Passe valide!"];
                    }else{
                        $error = ["type" => "formatPassword", "message" => "Merci de saisir un Mot de Passe valide!"];
                        $flag = 1;
                    }
                }

                if($flag == 0){
                    $etape = 3;
                }
            }else{
                $error = verifInput($flag);
            }
        }
    
    default:
        # code...
        break;
}


function verifInput($flag){
    $error = "";

    if($flag == 0){
        if($_POST["name"] == ""){
            $error = ["type" => "emptyName", "message" => "Merci de saisir un Nom!"];
        }else{
            if($_POST["firstname"] == ""){
                $error = ["type" => "emptyFirstName", "message" => "Merci de saisir un Prénom!"];
            }
        }
    }

    return $error;
}

include "../view/register.php";
