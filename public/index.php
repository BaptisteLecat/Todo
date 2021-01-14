<?php

require('controller.php');

$controller = new Controller();

if(isset($_SESSION["User"])){
    if (isset($_GET["action"]) && isset($_GET["view"])) {
        switch ($_GET["view"]) {
            case 'home':
                $controller->displayHome();
                break;
            case 'todo-board':
                //displayTodoBoard($_GET["action"]);
                break;
            case 'form-TaskTodo':
                //displayForm_TaskTodo($_GET["action"]);
                break;
            default:
                $controller->displayHome();
                break;
        }
    }else{
        $controller->displayHome();
    }
}else{
    $controller->displayForm_LoginRegister("login");
}
