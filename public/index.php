<?php

require('controller.php');

$controller = new Controller();

if (isset($_SESSION["User"])) {
    if (isset($_GET["view"])) {
        switch ($_GET["view"]) {
            case 'home':
                $controller->displayHome();
                $controller->menu($_GET["view"]);
                break;

            case 'todo-board':
                if(isset($_GET["action"]) && isset($_GET["id"])){
                    $controller->displayTodo($_GET["action"], $_GET["id"]);
                }else{
                    $controller->displayTodo();
                }
                $controller->menu($_GET["view"]);
                break;

            case 'form-TaskTodo':
                if(isset($_GET["action"])){
                    $controller->displayForm_TaskTodo($_GET["action"]);
                }else{
                    $controller->displayForm_TaskTodo(null);
                }
                $controller->menu($_GET["view"]);
                break;

            case 'login':
                $controller->displayForm_LoginRegister("login");
                break;

            case 'stats':
                require('../view/todo/todo.php');
                break;

            default:
                $controller->displayHome();
                $controller->menu();
                break;
        }
    } else {
        $controller->displayHome();
        $controller->menu();
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
    }else{
        $controller->displayForm_LoginRegister("login");
    }
}

require("../view/template.php");
