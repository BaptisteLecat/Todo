<?php
session_start();

require_once '../vendor/autoload.php';
require_once 'loader.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\TodoIconManager;
use App\Model\UserManager;
use App\Model\Utils\MessageBox;
use App\App;

class Controller
{

    //List constante de la BDD
    private $list_priority;
    private $list_todoIcon;

    private $user;

    private $css_link; //racine = /css/*****.css
    private $title;
    private $content;
    private $messageBox;

    function __construct()
    {

        $this->list_priority = loadPriority();
        $this->list_todoIcon = loadTodoIcon();
        $this->list_permission = loadPermission();
        $this->user = null;
        $this->app = null;
        $this->css_link = array();
        $this->title = "Todo";
        $this->messageBox = null;

        if (isset($_SESSION["User"])) {
            $this->user = unserialize($_SESSION["User"]);
            $this->reloadUser();
        }

        if (isset($_SESSION["App"])) {
            $this->app = unserialize($_SESSION["App"]);
        }else{
            $this->app = new App();
            $this->app->setList_Priority(loadPriority());
            $this->app->setList_TodoIcon(loadTodoIcon());
            $this->app->setList_Permission(loadPermission());
            $_SESSION["App"] = serialize($this->app);
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
        loadUserTodo($this->user, $this->list_todoIcon);
        loadUserTask($this->user, $this->list_priority);
        $_SESSION["User"] = serialize($this->user);
    }

    private function loadTodoIcon()
    {
        return loadTodoIcon();
    }

    /****************************************/
    /***************HTML VIEWS***************/
    /****************************************/

    public function head()
    {
        //<script src="https://code.jquery.com/mobile/1.5.0-rc1/jquery.mobile-1.5.0-rc1.js"></script>
        $head = '
        <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@500&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
            <base href="http://todo/"/>
            <link rel="stylesheet" href="assets/css/menu.css">
            <link rel="stylesheet" href="assets/css/messageBox/template.css">';
        $head .= $this->loadcss_link();
        $head .= '<script src="js/messageBox/messageBoxDisplayer.js"></script>';
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

    private function menu($view = null)
    {
        if ($view === null) {
            $view = "home";
        }
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

        require 'controllers/home/home.php';

        $this->menu();
    }

    public function displayForm_LoginRegister($action)
    {
        switch ($action) {
            case 'login':
                $this->title = "Login";
                $this->css_link = array("login");

                require('controllers/form/login.php');
                break;

            case 'register':
                $this->title = "Register";
                $this->css_link = array("register");

                require('controllers/form/register.php');
                break;

            default:
                $this->title = "Login";
                $this->css_link = array("login");

                require('controllers/form/login.php');
                break;
        }
    }

    public function displayTodo($id = null)
    {
        $this->reloadUser();
        loadUserTodoContribute($this->user, $this->list_todoIcon, $this->list_permission);
        loadTodoContributeTask($this->user, $this->list_priority);

        if ($id != null) {
            $isFinded = false;
            foreach ($this->user->getList_Todo() as $todo) {
                if ($todo->getId() == $id) {
                    $this->css_link = array('app', 'todo/todo');
                    require('controllers/board/todo/todoOwner.php');
                    $isFinded = true;
                    break;
                }
            }

            if (!$isFinded) {

                foreach ($this->user->getList_TodoContribute() as $todo) {
                    if ($todo->getId() == $id) {
                        $this->css_link = array('app', 'todo/todo');
                        require('controllers/board/todo/todoContributor.php');
                        $isFinded = true;
                        break;
                    }
                }

                if (!$isFinded) {
                    require('../view/board/board.php');
                    $this->css_link = array('app', 'todoView');
                }
            }
        } else {
            $this->css_link = array('app', 'todoView');
            require('../view/board/board.php');
        }

        $this->menu("board");
    }

    public function displayTodoSettings($settings, $section = null)
    {
        if ($settings == "settings") {
            switch ($section) {
                case 'informations':
                    # code...
                    break;

                case 'invitations':
                    # code...
                    break;

                case 'archives':
                    # code...
                    break;

                default:
                    //Page accueil settings
                    require('../view/board/settings/home.php');
                    $this->css_link = array('app', 'board/settings/home');
                    break;
            }
        } else {
            //Page accueil settings
            require('../view/board/settings/home.php');
            $this->css_link = array('app', 'board/settings/home');
        }

        $this->menu("board");
    }

    public function displayForm_TaskTodo($action = null)
    {
        $this->reloadUser();
        $list_todoIcons = $this->loadTodoIcon();

        require 'module/taskDisplayer/function/dayDisplayer.php';
        $messageBox = null;

        switch ($action) {
            case 'createtask':
                $this->title = "Ajout Tâche";
                $this->css_link = array("app", "form/formTodoTask/form", "messageBox/information");

                require('controllers/form/taskForm.php');
                break;

            case 'createtodo':
                $this->title = "Ajout Todo";
                $this->css_link = array("app", "form/formTodoTask/form", "form/formTodoTask/todoIcon", "messageBox/information");

                require('controllers/form/todoForm.php');
                break;

            default:
                $this->title = "Ajout Tâche";
                $this->css_link = array("app", "form/formTodoTask/form", "messageBox/information");

                require('controllers/form/taskForm.php');
                break;
        }

        $this->menu("todo");
    }
}
