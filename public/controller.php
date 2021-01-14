<?php
session_start();

require_once '../vendor/autoload.php';
require_once 'loader.php';

use App\Model\TodoManager;
use App\Model\TaskManager;
use App\Model\TodoIconManager;
use App\Model\UserManager;

class Controller
{
    private $todoManager;
    private $todoIconManager;
    private $taskManager;
    private $userManager;
    private $user;

    function __construct()
    {
        $this->todoManager = new TodoManager();
        $this->todoIconManager = new todoIconManager();
        $this->taskManager = new taskManager();
        $this->userManager = new UserManager();
        $this->user = null;
        if (isset($_SESSION["User"])) {
            $this->user = unserialize($_SESSION["User"]);
            $this->reloadUser();
        }
    }

    private function reloadUser()
    {
        drainUser($this->user);
        loadUserTodo($this->user, $this->todoManager, $this->todoIconManager);
        loadUserTask($this->user, $this->taskManager);
        $_SESSION["User"] = serialize($this->user);
    }

    public function displayHome()
    {
        require 'home.php';
    }

    public function displayForm_LoginRegister($action)
    {
        switch ($action) {
            case 'login':
                require('login.php');
                break;

            default:
                require('login.php');
                break;
        }
    }
}
