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

                case 'login':
                    $controller->displayForm_LoginRegister("login");
                    break;

                case 'stats':
                    require('../view/todo/todo.php');
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
                case 'login':
                    $controller->displayForm_LoginRegister("login");
                    break;

                case 'register':
                    $controller->displayForm_LoginRegister("register");
                    break;

                default:
                    $controller->displayForm_LoginRegister("login");
                    break;
            }
        } else {
            $controller->displayForm_LoginRegister("login");
        }
    }
}

require("../view/template.php");
