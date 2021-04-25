<?php

namespace App\Model\Exceptions;

use Exception;

class TaskDisplayerException extends Exception
{
    public function __construct(int $code)
    {
        parent::__construct("", $code);
    }

    public function __toString()
    {
        switch ($this->code) {
            case 1:
                $messageBox = new MessageBox("Ce jour semble incorrect.", "error", "error");
                break;

            default:
                $messageBox = new MessageBox("L'affichage des tâches est impossible.", "error", "error");
                break;
        }

        return $messageBox->formatToHTML();
    }
}
