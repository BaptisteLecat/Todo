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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && isset($_POST['firstname'])) {
        $INPUT_ARGS = array(
            'name' => FILTER_SANITIZE_STRING,
            'firstname' => FILTER_SANITIZE_STRING
        );
        $filtered_input = filter_input_array(INPUT_POST, $INPUT_ARGS);
        if (!is_null($filtered_input) && $filtered_input == true) {
            try {

                $etape = 1;
                $signUp = new SignUp($filtered_input["name"], $filtered_input["firstname"]);
                $etape = ($signUp->validFirstStep()) ? 2 : 1;
                $_SESSION["SignUp"] = serialize($signUp);
            } catch (Exception $e) {
                $this->messageBox = $e;
                $etape = 1;
            }
        }
    } else {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $INPUT_ARGS = array(
                'email' => FILTER_VALIDATE_EMAIL,
                'password' => FILTER_SANITIZE_STRING
            );
            $filtered_input = filter_input_array(INPUT_POST, $INPUT_ARGS);
            if (!is_null($filtered_input) && $filtered_input == true) {
                try {

                    if (isset($_SESSION["SignUp"])) {
                        $etape = 2;
                        $signUp = unserialize($_SESSION["SignUp"]);
                        $etape = $signUp->signUp($filtered_input['email'], $filtered_input['password']);
                        header('refresh:2.3;url=login');

                        $successMessage = new SuccessManager("Succès de l'authentification ! ", "success");
                        $this->messageBox = $successMessage;
                    } else {
                        //throw new Exception("Une erreur est survenue !");
                        $etape = 1;
                    }
                } catch (Exception $e) {
                    $this->messageBox = $e;
                    $etape = 2;
                }
            }
        }
    }
} else {
    $etape = 1;
}

include '../view/form/signUp.php';
