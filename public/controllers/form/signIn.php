<?php

use App\Model\Form\Sign\SignIn;
use App\Model\Utils\VisitorCounter;
use App\Model\Exceptions\SuccessManager;

session_destroy();
session_start();

const INPUT_ARGS = array(
    'email' => FILTER_VALIDATE_EMAIL,
    'password' => FILTER_SANITIZE_STRING
);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filtered_input = filter_input_array(INPUT_POST, INPUT_ARGS);
    if (!is_null($filtered_input) && $filtered_input == true) {
        try {
            $signIn = new SignIn(trim($filtered_input["email"]), $filtered_input["password"]);
            $_SESSION["User"] = serialize($signIn->signIn());
            header('refresh:2.3;url=home');


            if (VisitorCounter::getInstanceCount() == 0) {
                $visitor = new VisitorCounter();
            }

            $successMessage = new SuccessManager("Succès de l'authentification ! ", "success");
            $this->messageBox = $successMessage;
        } catch (Exception $e) {
            $this->messageBox = $e;
        }
    //TODO LE Systeme de gestion des erreurs n'est pas fonctionnelle pour les erreurs native, qui ne s'afficheront pas en messageBox.
    }
}

include '../view/form/signIn.php';
