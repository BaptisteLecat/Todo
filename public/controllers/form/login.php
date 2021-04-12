<?php

use App\Model\Form\Sign\SignIn;
use App\Model\Utils\VisitorCounter;
use App\Model\Exceptions\SuccessManager;

session_destroy();
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    try{
        $signIn = new SignIn($_POST["email"], $_POST["password"]);
        $_SESSION["User"] = serialize($signIn->signIn());
        header('refresh:2.3;url=home');

        
        if (VisitorCounter::getInstanceCount() == 0) {
            $visitor = new VisitorCounter();
        }

        $successMessage = new SuccessManager("Succès de l'authentification ! ", "success");
        $this->messageBox = $successMessage;
    }catch (Exception $e) {
        $this->messageBox = $e;
    }
    //TODO LE Systeme de gestion des erreurs n'est pas fonctionnelle pour les erreurs native, qui ne s'afficheront pas en messageBox.
}

include '../view/form/login.php';
