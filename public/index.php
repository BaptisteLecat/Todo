<?php

require('controller.php');

$controller = new Controller();

if (isset($_GET["error"])) {
    var_dump($_GET["error"]);
} else {
    if (isset($_SESSION["User"])) {
        if (isset($_GET["view"])) {
            switch ($_GET["view"]) {
                case 'home':
                    $controller->displayHome();
                    break;

                case 'board':
                    if (isset($_GET["idTodo"])) {
                        if (isset($_GET["settings"])) {
                            if (isset($_GET["section"])) {
                                $controller->displayTodoSettings($_GET["settings"], $_GET["section"]);
                            } else {
                                $controller->displayTodoSettings($_GET["settings"]);
                            }
                        } else {
                            $controller->displayTodo($_GET["idTodo"]);
                        }
                    } else {
                        $controller->displayTodo();
                    }
                    break;

                case 'form':
                    if (isset($_GET["action"])) {
                        $controller->displayForm_TaskTodo($_GET["action"]);
                    } else {
                        $controller->displayForm_TaskTodo();
                    }
                    break;

                case 'signIn':
                    $controller->displayForm_LoginRegister("login");
                    break;

                case 'social':
                    $controller->displaySocial();
                    break;

                default:
                    $controller->displayHome();
                    break;
            }
        } else {
            $controller->displayHome();
        }
    } else {
        if (isset($_GET["view"])) {
            switch ($_GET["view"]) {
                case 'signIn':
                    $controller->displayForm_LoginRegister("signIn");
                    break;

                case 'signUp':
                    $controller->displayForm_LoginRegister("signUp");
                    break;

                default:
                    $controller->displayForm_LoginRegister("signIn");
                    break;
            }
        } else {
            $controller->displayForm_LoginRegister("signIn");
        }
    }
}

require("../view/template.php");
