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

include '../view/form/signUp.php';
