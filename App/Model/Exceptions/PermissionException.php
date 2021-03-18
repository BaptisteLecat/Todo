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
                $stringMessage = "Vous n'avez pas la permission d'achever une tâche";
                $messageBox = new MessageBox(null, "error");
                break;

            case 2:
                $stringMessage = "Vous n'avez pas la permission de modifier une tâche";
                $messageBox = new MessageBox(null, "error");
                break;

            case 3:
                $stringMessage = "Vous n'avez pas la permission de créer une tâche";
                $messageBox = new MessageBox(null, "error");
                break;

            case 4:
                $stringMessage = "Vous n'avez pas la permission d'archiver une tâche";
                $messageBox = new MessageBox(null, "error");
                break;

            default:
                $stringMessage = "Les permissions nécessaires ne vous sont pas accordées.";
                $messageBox = new MessageBox(null, "error");
                break;
        }

        return $messageBox->formatToHTML($stringMessage);
    }
}
