<?php

namespace App\Model\Form\CreateForm;

use App\App;
use App\Model\Form\Form;
use App\Model\Entity\User;
use App\Model\Exceptions\FormException;
use App\Model\Exceptions\PermissionException;
use App\Model\TaskManager;
use App\Model\TodoManager;

class FormTodo extends Form
{
    private $title;
    private $description;
    private $idIcon;

    public function __construct(string $title, string $description, int $idIcon, User $user, App $app)
    {
        parent::__construct($user, $app);
        $this->title = $title;
        $this->description = $description;
        $this->idIcon = $idIcon;
    }

    public function submitForm()
    {
        $list_input = array("title_todo" => $this->title, "description_todo" => $this->description);

        //Verification de la syntaxe des champs.
        if ($this->verifInput($list_input)) {
            //Verification de l'existance des id passé en paramètres. Récupération des objects associés.
            $iconObject = $this->getIconObject($this->idPriority);
            if (!is_null($iconObject)) {
                //Insertion des informations.
                TodoManager::insertTodo($this->title, $this->description, $this->user, $iconObject);
            } else {
                throw new FormException(2);
            }
        }
    }
}
