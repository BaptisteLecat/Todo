<?php

namespace App\Model\Form;

use App\App;
use DateTime;
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

    public function __construct(User $user = null, App $app = null)
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

            case 'title_task':
                $titleTaskSettings = $this->inputSettings->getTitleTaskConfig();
                if (!empty($titleTaskSettings)) {
                    if (strlen($value) > $titleTaskSettings["maxLength"]) {
                        throw new InputException(4, "titre", $titleTaskSettings["maxLength"]);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'content_task':
                $contentTaskSettings = $this->inputSettings->getContentTaskConfig();
                if (!empty($contentTaskSettings)) {
                    if (strlen($value) > $contentTaskSettings["maxLength"]) {
                        throw new InputException(4, "contenu", $contentTaskSettings["maxLength"]);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'endDate_task':
                //Conformité de la date : format, postériorité
                $endDateTaskSettings = $this->inputSettings->getEndDateTaskConfig();
                if (!empty($endDateTaskSettings)) {
                    //Verification du format de la date.
                    $date = DateTime::createFromFormat($endDateTaskSettings["dateFormat"], $value);
                    if ($date) {
                        //Vérification de la postériorité de la date.
                        if($date < date("Y-m-d")){
                            throw new InputException(6);
                        }
                    }else{    
                        throw new InputException(5);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'title_todo':
                $titleTodoSettings = $this->inputSettings->getTitleTodoConfig();
                if (!empty($titleTodoSettings)) {
                    if (strlen($value) > $titleTodoSettings["maxLength"]) {
                        throw new InputException(4, "titre", $titleTodoSettings["maxLength"]);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'description_todo':
                $descriptionTodoSettings = $this->inputSettings->getDescriptionTodoConfig();
                if (!empty($descriptionTodoSettings)) {
                    if (strlen($value) > $descriptionTodoSettings["maxLength"]) {
                        throw new InputException(4, "description", $descriptionTodoSettings["maxLength"]);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
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
