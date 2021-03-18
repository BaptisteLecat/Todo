<?php

namespace App\Model\Exceptions;

use Exception;

class PermissionException extends Exception
{
    public function __construct(int $code)
    {
        parent::__construct("", $code);
    }

    public function __toString()
    {
        switch ($this->code) {
            case 1:
                $messageBox = new MessageBox("Erreur", "Vous n'avez pas la permission d'achever une tâche", null, "error");
                break;

            case 2:
                $messageBox = new MessageBox("Erreur", "Vous n'avez pas la permission de modifier une tâche", null, "error");
                break;

            case 3:
                $messageBox = new MessageBox("Erreur", "Vous n'avez pas la permission de créer une tâche", null, "error");
                break;

            case 4:
                $messageBox = new MessageBox("Erreur", "Vous n'avez pas la permission d'archiver une tâche", null, "error");
                break;

            default:
                $messageBox = new MessageBox("Erreur", "Les permissions nécessaires ne vous sont pas accordées.", null, "error");
                break;
        }

        return $messageBox->formatToHTML();
    }
}
