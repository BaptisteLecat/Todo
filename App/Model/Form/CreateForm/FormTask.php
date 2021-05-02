<?php

namespace App\Model\Form\CreateForm;

use App\App;
use App\Model\Form\Form;
use App\Model\Entity\User;
use App\Model\Exceptions\FormException;
use App\Model\Exceptions\PermissionException;
use App\Model\TaskManager;

class FormTask extends Form
{
    private $title;
    private $content;
    private $endDate;
    private $idTodo;
    private $idPriority;

    public function __construct(string $title, string $content, string $endDate, int $idTodo, int $idPriority, User $user, App $app)
    {
        parent::__construct($user, $app);
        $this->title = $title;
        $this->content = $content;
        $this->endDate = $endDate;
        $this->idTodo = $idTodo;
        $this->idPriority = $idPriority;
    }

    public function submitForm()
    {
        $list_input = array("title_task" => $this->title, "content_task" => $this->content, "endDate_task" => $this->endDate);

        //Verification de la syntaxe des champs.
        if ($this->verifInput($list_input)) {
            //Verification de l'existance des id passé en paramètres. Récupération des objects associés.
            $todoObject = $this->getTodoObject($this->idTodo);
            $priorityObject = $this->getPriorityObject($this->idPriority);
            if (!is_null($todoObject)) {
                if (!is_null($priorityObject)) {
                    //Verification des droits de l'utilisateur.
                    if ($todoObject->getOwned() || ($todoObject->havePermissionTo(3) && $this->user->isAcceptedInTodo($todoObject))) {
                        //Insertion des informations.
                        TaskManager::insertTask($this->title, $this->content, $this->endDate, $priorityObject, $todoObject, $this->user);
                    } else {
                        throw new PermissionException(1);
                    }
                } else {
                    throw new FormException(1);
                    
                }
            } else {
                throw new FormException(0);
            }
        }
    }
}
