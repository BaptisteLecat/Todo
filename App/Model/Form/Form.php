<?php

namespace App\Model\Form;

use App\App;
use Exception;
use App\Model\Entity\User;
use App\Model\Exceptions\InputException;
use App\Model\XMLSettings\XMLInputSettings;
use App\Model\Exceptions\InputSignException;

class Form
{
    protected $inputSettings;

    protected $user;
    protected $app;

    public function __construct(User $user, App $app)
    {
        $this->inputSettings = new XMLInputSettings($_SERVER['DOCUMENT_ROOT'] . "/../App/Settings/input.xml", null, true);
        $this->user = $user;
        $this->app = $app;
    }

    public function __sleep()
    {
        return array();
    }

    protected function verifInput($list_input)
    {
        $success = false;
        foreach (array_keys($list_input) as $inputTitle) {
            if (!is_null($list_input[$inputTitle])) {
                $this->checkInputSyntax($inputTitle, $list_input[$inputTitle]);
                $success = true;
            } else {
                throw new InputException(0, $inputTitle);
            }
        }

        return $success;
    }

    private function checkInputSyntax($inputName, $value)
    {
        switch ($inputName) {
            case 'email':
                $emailSettings = $this->inputSettings->getEmailConfig();
                if (!empty($emailSettings)) {
                    if (!preg_match($emailSettings["regex"], $value)) {
                        throw new InputSignException(1);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'password':
                $passwordSettings = $this->inputSettings->getPasswordConfig();
                if (!empty($passwordSettings)) {
                    if (strlen($value) < $passwordSettings["minLength"]) {
                        throw new InputSignException(2);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'name':

                break;

            case 'firstName':

                break;

            default:
                throw new Exception("Champs inconnu.");
                break;
        }
    }

    protected function getTodoObject(int $idTodo)
    {
        $todoObject = null;
        $isFinded = false;
        foreach ($this->user->getList_Todo() as $todo) {
            if ($todo->getId() == $idTodo) {
                $todoObject = $todo;
                $isFinded = true;
                break;
            }
        }

        if (!$isFinded) {
            foreach ($this->user->getList_TodoContribute() as $todo) {
                if ($todo->getId() == $idTodo) {
                    $todoObject = $todo;
                    break;
                }
            }
        }
        return $todoObject;
    }

    protected function getPriorityObject(int $idPriority)
    {
        $priorityObject = null;

        foreach ($this->app->getList_Priority() as $priority) {
            if ($priority->getId() == $idPriority) {
                $priorityObject = $priority;
                break;
            }
        }

        return $priorityObject;
    }

    protected function getIconObject(int $idIcon)
    {
        $iconObject = null;

        foreach ($this->app->getList_TodoIcon() as $icon) {
            if ($icon->getId() == $idIcon) {
                $iconObject = $icon;
                break;
            }
        }

        return $iconObject;
    }
}
