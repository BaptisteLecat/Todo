<?php 

require_once '../vendor/autoload.php';

use App\Model\PasswordManager;
use App\Model\TodoManager;

$passwordManager = new PasswordManager();

if(isset($_POST["email"])){
    $error = verifEmail($passwordManager);
}

function verifEmail($userObject){
    $error = "";
    if($_POST["email"] != ""){
        if (preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $_POST["email"])) {
            $resultVerifLogin = $userObject->emailIsValid($_POST['email']);
            if ($resultVerifLogin["success"] == 1) {
                $error = ["message" => sendToken($userObject, $_POST["email"])];
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

    if($_POST["email"] == ""){
        $error = ["type" => "emptyEmail", "message" => "Merci de saisir une email!"];
    }

    return $error;
}

function sendToken($userObject, $email){
    $message = "";
    $resultSendEmail = $userObject->sendEmail($email);
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

include "../view/losePassword.php";