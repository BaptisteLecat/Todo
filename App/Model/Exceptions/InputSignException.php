<?php

namespace App\Model\Exceptions;

class InputSignException extends InputException
{

    public function __construct(int $code = null, string $inputName = null, string $info = null)
    {
        parent::__construct($code, $inputName, $info);
    }

    public function __toString()
    {
        switch ($this->code) {
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
