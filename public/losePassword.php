<?php 

require_once '../vendor/autoload.php';

use App\Model\PasswordManager;

$passwordManager = new PasswordManager();

if(isset($_POST["email"])){
    $error = verifEmail($passwordManager);
    
}else{
    echo("coucou");
}

function verifEmail($userObject){
    $error = "";
    if($_POST["email"] != ""){
        if (preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $_POST["email"])) {
            $resultVerifLogin = $userObject->emailIsValid($_POST['email']);
            if ($resultVerifLogin["success"] == 1) {
                //Login ok
            } else {
                $error = ["type" => "login", "message" => "Identifiant incorrect!"];
            }
        } else {
            $error = ["type" => "email", "message" => "Format de l'email incorrect!"];
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

include "../view/losePassword.php";