<?php 

require_once '../vendor/autoload.php';

use App\Model\PasswordManager;
use App\Model\TodoManager;

$passwordManager = new PasswordManager();

if(isset($_POST["etape"])){
    $etape = $_POST["etape"];
}else{
    $etape = 1;
}

if(isset($_POST["email"]) && $_POST["etape"] == 1){
    $error = verifEmail($passwordManager);
    if(isset($error["etape"])){
        $etape = $error["etape"];
    }
}

if(isset($_POST["token"]) && $_POST["etape"] == 2){
    $error = verifToken($passwordManager);
}

#region Etape1

function verifEmail($object){
    $error = "";
    if($_POST["email"] != ""){
        if (preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $_POST["email"])) {
            $resultVerifLogin = $object->emailIsValid($_POST['email']);
            if ($resultVerifLogin["success"] == 1) {
                $error = ["message" => sendToken($object, $_POST["email"]), "etape" => 2];
            } else {
                $error = ["message" => "Identifiant incorrect!"];
            }
        } else {
            $error = ["message" => "Format de l'email incorrect!"];
        }
    
    }else{
        $error = verifInput();
    }

    return $error;
}

function verifInput(){
    $error = "";

    switch ($_POST["etape"]) {
        case 1:
            if($_POST["email"] == ""){
                $error = ["message" => "Merci de saisir une Email!"];
            }
            break;
        
        case 2:
            if($_POST["token"] == ""){
                $error = ["message" => "Merci de saisir un Token!"];
            }
            break;
        
        default:
            # code...
            break;
    }


    return $error;
}

function sendToken($object, $email){
    $message = "";
    $resultSendEmail = $object->sendEmail($email);
    if($resultSendEmail["success"] == 1){      
        $message = "Envoie avec succes de votre token d'identification.";
    }else{
        switch ($resultSendEmail["typeError"]) {
            case 'EmailSend':
                $message = "Une erreur est survenue lors de l'envoi du mail d'identification.";
                break;

            case 'ResetLimit':
                $message = "Vous avez atteint le nombre maximum de changement de Mot de Passe. Veuillez contacter le support.";
                break;

            default:
                $message = "Une erreur système est survenue.";
                break;
        }
    }
    
    return $message;
}

#endregion


function verifToken($object){
    $error = "";
    var_dump("coucou");
    if($_POST["token"] != ""){
        if (preg_match("#[1-9A-Z]#", $_POST["token"])) {
            $resultVerifLogin = $object->tokenIsValid($_POST['token']);
            if ($resultVerifLogin["success"] == 1) {
                $error = ["message" => "Le Token est valide."];
            } else {
                $error = ["message" => "Token incorrect!"];
            }
        } else {
            $error = ["message" => "Format du Token incorrect!"];
        }
    
    }else{
        $error = verifInput();
    }

    return $error;
}

include "../view/form/losePassword.php";