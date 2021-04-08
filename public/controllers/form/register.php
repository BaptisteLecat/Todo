<?php
/*
if (isset($_POST["etape"])) {
    $etape = $_POST["etape"];
} else {
    $etape = 1;
}

$registerInfo = array();*/

use App\Model\Exceptions\SuccessManager;
use App\Model\Form\Sign\SignUp;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['name']) && isset($_POST['firstname'])) {
    try{
        
        $etape = 1;
        $signUp = new SignUp($_POST["name"], $_POST["firstname"]);
        $etape = ($signUp->validFirstStep()) ? 2 : 1;
        $_SESSION["SignUp"] = serialize($signUp);

    }catch (Exception $e) {
        $this->messageBox = $e;
        $etape = 1;
    }
}else{
    if (isset($_POST['email']) && isset($_POST['password'])) {
        try {

            if(isset($_SESSION["SignUp"])){
                $etape = 2;
                $signUp = unserialize($_SESSION["SignUp"]);
                $etape = $signUp->signUp($_POST['email'], $_POST['password']);
                header('refresh:2.3;url=login');

                $successMessage = new SuccessManager("Succès de l'authentification ! ", "success");
                $this->messageBox = $successMessage;
            }else{
                //throw new Exception("Une erreur est survenue !");
                $etape = 1;
            }
        } catch (Exception $e) {
            $this->messageBox = $e;
            $etape = 2;
        }
    }else{
        $etape = 1;
    }
}

include '../view/form/login.php';


/*
switch ($etape) {
    case 1: //Premier étape de la saisie, début.
        $flag = 0;
        if (isset($_POST['name']) || isset($_POST['firstname'])) {

            if ($_POST["name"] != "" && $_POST["firstname"] != "") {
                if (preg_match("#[^a-zA-ZéÉèÈëËêÊàÀâÂäÄùÙûÛïÏîÎôÔöÖçÇ]#", $_POST["name"]) == 1) {
                    $error = ["input" => "first", "type" => "formatName", "message" => "Merci de saisir un Nom valide!"];
                    $flag = 1;

                    
                    $registerInfo["name"] = $_POST["name"];
                    $registerInfo["firstname"] = $_POST["firstname"];
                    
                }

                if (preg_match("#[^a-zA-ZéÉèÈëËêÊàÀâÂäÄùÙûÛïÏîÎôÔöÖçÇ]#", $_POST["firstname"]) == 1) {
                    if ($flag == 1) {
                        $error = ["input" => "both", "type" => "formatName_FirstName", "message" => "Merci de saisir un Nom et un Prénom valide!"];
                    } else {
                        $error = ["input" => "second", "type" => "formatFirstName", "message" => "Merci de saisir un Prénom valide!"];
                        $flag = 1;
                    }

                    
                    $registerInfo["name"] = $_POST["name"];
                    $registerInfo["firstname"] = $_POST["firstname"];
                    
                }

                if ($flag == 0) {
                    $etape = 2;
                    
                    $registerInfo["name"] = $_POST["name"];
                    $registerInfo["firstname"] = $_POST["firstname"];
                    $_SESSION["register"] = serialize($registerInfo);
                }
            } else {
                $error = verifInput($etape, $registerInfo);
            }
        }
        break;

    case 2:
        $flag = 0;
        if (isset($_POST['email']) || isset($_POST['password'])) {

            if ($_POST["email"] != "" && $_POST["password"] != "") {
                if (preg_match("/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/", $_POST["email"]) == 0) {
                    $error = ["input" => "first", "type" => "formatEmail", "message" => "Email invalide!"];
                    $flag = 1;

                    $registerInfo["email"] = $_POST["email"];
                    $registerInfo["password"] = $_POST["password"];
                }

                if (preg_match("#^(?=.*[A-Za-z])(?=.*\d)(?=.*[&-+!*$@%_])([&-+!*$@%_\w]{8,25})$#", $_POST["password"]) == 0) {
                    if ($flag == 1) {
                        $error = ["input" => "both", "type" => "formatEmail_Password", "message" => "Email et Mot de Passe invalide!<br>Au moins 1 lettre, 1 chiffre, 1 caractère spécial et 8 caractères."];
                    } else {
                        $error = ["input" => "second", "type" => "formatPassword", "message" => "Mot de Passe invalide!<br>Au moins 1 lettre, 1 chiffre, 1 caractère spécial et 8 caractères."];
                        $flag = 1;
                    }

                    $registerInfo["email"] = $_POST["email"];
                    $registerInfo["password"] = $_POST["password"];
                }

                if ($flag == 0) {
                    $etape = 1;
                    //Verification de l'email
                    $resultEmailValid = $this->userManager->emailIsValid($_POST["email"]);
                    if ($resultEmailValid["success"] == 1) {
                        if ($resultEmailValid["isValid"] == true) {
                            //Create Account
                            $resultCreateAccount = $this->userManager->createAccount($registerInfo["name"], $registerInfo["firstname"], $_POST["email"], $_POST["password"]);
                            if($resultCreateAccount["success"] == 1){
                                header("Location: index.php?view=login");
                            }
                        }
                    }
                }
            } else {
                $error = verifInput($etape, $registerInfo);
            }
        }

    default:
        # code...
        break;
}*/

include "../view/form/register.php";
