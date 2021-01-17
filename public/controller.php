<?php
session_start();

require_once '../vendor/autoload.php';
require_once 'loader.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\TodoIconManager;
use App\Model\UserManager;
use App\Model\Utils\MessageBox;

class Controller
{
    private $todoManager;
    private $todoIconManager;
    private $taskManager;
    private $userManager;
    private $user;
    private $css_link; //racine = /css/*****.css
    private $title;
    private $content;
    private $messageBox;

    function __construct()
    {
        $this->todoManager = new TodoManager();
        $this->todoIconManager = new todoIconManager();
        $this->taskManager = new taskManager();
        $this->userManager = new UserManager();
        $this->user = null;
        $this->css_link = array();
        $this->title = "Todo";
        $this->messageBox = null;
        if (isset($_SESSION["User"])) {
            $this->user = unserialize($_SESSION["User"]);
            $this->reloadUser();
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMessageBox()
    {
        return $this->messageBox;
    }

    public function getContent()
    {
        return $this->content;
    }
    /****************************************/
    /****************LOADERS*****************/
    /****************************************/

    private function reloadUser()
    {
        drainUser($this->user);
        loadUserTodo($this->user, $this->todoManager, $this->todoIconManager);
        loadUserTask($this->user, $this->taskManager);
        $_SESSION["User"] = serialize($this->user);
    }

    private function loadTodoIcon()
    {
        return loadTodoIcon($this->todoIconManager);
    }

    /****************************************/
    /***************HTML VIEWS***************/
    /****************************************/

    public function head()
    {
        $head = '
         <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <link rel="stylesheet" href="assets/css/menu.css">';
        $head .= $this->loadcss_link();
        $head .= '<script src="module/form/messageBox/messageBoxDisplayer.js"></script>';
        $head .= '<title>
            ' . $this->title . '
            </title>
        </head>';

        return $head;
    }

    private function loadcss_link()
    {
        $html_link = "";
        foreach ($this->css_link as $css) {
            $html_link .= '<link rel="stylesheet" href="assets/css/' . $css . '.css">';
        }
        return $html_link;
    }

    private function menu()
    {

        include_once("../view/menu.php");
    }


    /****************************************/
    /************DISPLAYER VIEWS************/
    /****************************************/

    public function displayHome()
    {
        $this->reloadUser();
        $this->title = "Accueil";
        $this->css_link = array("app", "home", "todo", "stats", "todoState", "calendar");

        require 'home/home.php';
        $this->menu();
    }

    public function displayForm_LoginRegister($action)
    {
        switch ($action) {
            case 'login':
                $this->title = "Login";
                $this->css_link = array("login");

                require('form/login.php');
                break;

            case 'register':
                $this->title = "Register";
                $this->css_link = array("register");

                require('form/register.php');
                break;

            default:
                $this->title = "Login";
                $this->css_link = array("login");

                require('form/login.php');
                break;
        }
    }

    public function displayTodo($action = null)
    {
        $this->reloadUser();

        switch ($action) {
            case 'board':
                require('../view/todo/todoView.php');
                $this->css_link = array('app', 'todoView');
                break;

            case 'todo':
                require('../view/todo/todo.php');
                $this->css_link = array('app', 'todo/todo');
                break;

            default:
                require('../view/todo/todoView.php');
                $this->css_link = array('app', 'todoView');
                break;
        }
        $this->menu();
    }

    public function displayForm_TaskTodo($action = null)
    {
        $this->reloadUser();
        $list_todoIcons = $this->loadTodoIcon();

        require 'module/taskDisplayer/function/dayDisplayer.php';
        $messageBox = null;

        switch ($action) {
            case 'CreateTask':
                $this->title = "Ajout Tâche";
                $this->css_link = array("app", "form/formTodoTask/form", "messageBox/information");

                require('form/taskForm.php');
                break;

            case 'CreateTodo':
                $this->title = "Ajout Tâche";
                $this->css_link = array("app", "form/formTodoTask/form", "form/formTodoTask/todoIcon", "messageBox/information");

                require('form/todoForm.php');
                break;

            default:
                $this->title = "Ajout Tâche";
                $this->css_link = array("app", "form/formTodoTask/form", "messageBox/information");

                require('form/taskForm.php');
                break;
        }
        $this->menu();
    }
}
