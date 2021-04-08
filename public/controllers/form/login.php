<?php

use App\Model\Exceptions\SuccessManager;
use App\Model\Form\Sign\SignIn;

session_destroy();
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    try{
        $signIn = new SignIn($_POST["email"], $_POST["password"]);
        $_SESSION["User"] = serialize($signIn->signIn());
        header('refresh:2.3;url=home');

        $successMessage = new SuccessManager("Succès de l'authentification ! ", "success");
        $this->messageBox = $successMessage;
    }catch (Exception $e) {
        $this->messageBox = $e;
    }
    //TODO LE Systeme de gestion des erreurs n'est pas fonctionnelle pour les erreurs native, qui ne s'afficheront pas en messageBox.
}

include '../view/form/login.php';
