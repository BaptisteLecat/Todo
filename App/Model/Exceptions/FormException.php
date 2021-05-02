<?php

namespace App\Model\Exceptions;

use Exception;

class FormException extends Exception
{

    public function __construct(int $code = null)
    {
        parent::__construct("", $code);
    }

    public function __toString()
    {
        switch ($this->code) {
            case 0:
                $messageBox = new MessageBox("Cette Todo n'existe pas.", "error", "error");
                break;

            case 1:
                $messageBox = new MessageBox("Cette priorité n'existe pas.", "error", "error");
                break;

            case 2:
                $messageBox = new MessageBox("Cet icone n'existe pas.", "error", "error");
                break;

            case 3:
                $messageBox = new MessageBox("Vous avez atteint le nombre maximum de Todo.", "error", "error");
                break;

            default:
                $messageBox = new MessageBox("Une erreur est survenue.", "error", "error");
                break;
        }

        return $messageBox->formatToHTML();
    }
}
