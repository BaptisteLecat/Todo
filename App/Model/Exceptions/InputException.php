<?php

namespace App\Model\Exceptions;

use Exception;

class InputException extends Exception
{
    private $inputName;
    private $info;

    public function __construct(int $code = null, string $inputName = null, string $info = null)
    {
        parent::__construct("", $code);
        $this->inputName = $inputName;
        $this->info = $info;
    }

    public function __toString()
    {
        switch ($this->code) {
            case 0:
                $messageBox = new MessageBox("Veuillez remplir le champs : $this->inputName", "error", "error");
                break;

            case 1:
                $messageBox = new MessageBox("La saisie contient plus de $this->info caractères", "error", "error");
                break;

            case 2:
                $messageBox = new MessageBox("La saisie contient moins de $this->info caractères", "error", "error");
                break;

            default:
                $messageBox = new MessageBox("Erreur de saisie.", "error", "error");
                break;
        }

        return $messageBox->formatToHTML();
    }
}
