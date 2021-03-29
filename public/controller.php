<?php
session_start();

require_once '../vendor/autoload.php';

use App\App;
use App\Loader;
use App\Model\TaskManager;
use App\Model\TodoManager;
use App\Model\UserManager;
use App\Model\TodoIconManager;
use App\Model\Utils\MessageBox;
use App\Model\ContributeManager;

class Controller
{

    //App contient les constantes de la BDD.
    private $app;

    private $user;

    private $css_link; //racine = /css/*****.css
    private $title;
    private $content;
    private $messageBox;

    function __construct()
    {
        $this->user = null;
        $this->css_link = array();
        $this->title = "Todo";
        $this->messageBox = null;
        if(isset($_SESSION["User"])){
            $this->user = unserialize($_SESSION["User"]);
            $this->loadInformation();
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

    private function loadInformation()
    {
        if (isset($_SESSION["App"])) {
            $this->app = unserialize($_SESSION["App"]);
        } else {
            $this->app = new App();
            $this->app->setList_Priority(Loader::loadPriority());
            $this->app->setList_TodoIcon(Loader::loadTodoIcon());
            $this->app->setList_Permission(Loader::loadPermission());
            $_SESSION["App"] = serialize($this->app);
        }

        Loader::LoadUser($this->user, $this->app->getList_TodoIcon(), $this->app->getList_Priority());
    }

    /****************************************/
    /***************HTML VIEWS***************/
    /****************************************/

    public function head()
    {
        //<script src="https://code.jquery.com/mobile/1.5.0-rc1/jquery.mobile-1.5.0-rc1.js"></script>
        $head = '
        <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="../assets/icons/logoTodo.ico" />
        <meta http-equiv="content-type" content="text/html">
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

    private function goBack(){
        $url = "";
        if(substr($_SERVER['REQUEST_URI'], -1) == "/"){
            $url = $_SERVER['REQUEST_URI']."..";
        }else{
            $url = $_SERVER['REQUEST_URI'] . "/..";
        }
        return $url;
    }

    private function goTodo($idTodo)
    {
        $url = "";
        if (substr($_SERVER['REQUEST_URI'], -1) == "/") {
            $url = $_SERVER['REQUEST_URI'] . $idTodo;
        } else {
            $url = $_SERVER['REQUEST_URI'] . "/". $idTodo;
        }
        return $url;
    }


    /****************************************/
    /************DISPLAYER VIEWS************/
    /****************************************/

    public function displayHome()
    {
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
        Loader::loadContribute($this->user, $this->app->getList_TodoIcon(), $this->app->getList_Permission(), $this->app->getList_Priority());

        if ($id != null) {
            $todo = $this->findTodo($id);
            if (!is_null($todo)) {
                if ($todo->getOwned()) { //Todo ou le user est propriétaire.
                    $this->css_link = array('app', 'todo/todo');
                    require('controllers/board/todo/todoOwner.php');
                } else {
                    $this->css_link = array('app', 'todo/todo');
                    require('controllers/board/todo/todoContributor.php');
                }
            } else {
                require('../view/board/board.php');
                $this->css_link = array('app', 'todoView');
            }
        } else {
            $this->css_link = array('app', 'todoView');
            require('../view/board/board.php');
        }

        $this->menu("board");
    }

    private function findTodo(int $id)
    {
        $todoObject = null;
        $isFinded = false;
        foreach ($this->user->getList_Todo() as $todo) {
            if ($todo->getId() == $id) {
                $todoObject = $todo;
                $isFinded = true;
                break;
            }
        }

        if (!$isFinded) {

            foreach ($this->user->getList_TodoContribute() as $todo) {
                if ($todo->getId() == $id) {
                    $todoObject = $todo;
                    $isFinded = true;
                    break;
                }
            }
        }

        return $todoObject;
    }

    public function displayTodoSettings($settings, $section = null)
    {
        Loader::loadContribute($this->user, $this->app->getList_TodoIcon(), $this->app->getList_Permission(), $this->app->getList_Priority());

        if ($settings == "settings") {
            switch ($section) {
                case 'informations':
                    //Récupération de l'object todo associé à l'id passé dans l'url.
                    $todo = $this->findTodo($_REQUEST["idTodo"]);
                    //Chargement des userContributor et de leur permissions, pour cette todo.
                    $list_userContributor = ContributeManager::loadUsersOfTodo($todo, $this->app->getList_Permission());

                    if (!is_null($todo)) {
                        require('../view/board/settings/informations.php');
                        $this->css_link = array('app', 'board/settings/informations');
                    } else {
                        //Page accueil settings
                        require('../view/board/settings/home.php');
                        $this->css_link = array('app', 'board/settings/home');
                    }
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
            $this->displayTodo($_REQUEST["idTodo"]);
        }

        $this->menu("board");
    }

    public function displayForm_TaskTodo($action = null)
    {
        $list_todoIcons = $this->app->getList_TodoIcon();

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
