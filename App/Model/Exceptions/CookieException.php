<?php

namespace App\Model\Exceptions;

use Exception;

class CookieException extends Exception
{
    private $info;

    public function __construct(int $code = null, string $info = null)
    {
        parent::__construct("", $code);
        $this->info = $info;
    }

    public function __toString()
    {
        switch ($this->code) {
            case 1 :
                $messageBox = new MessageBox("Une erreur est survenue lors de la sauvegarde de vos données.", "error", "error");
                break;

            case 2:
                $messageBox = new MessageBox("Une connexion non sécurisée a été détectée. Veuillez vous reconnecter.", "error", "error");
                break;

            default:
                $messageBox = new MessageBox("L'authentification automatique a échoué. Veuillez vous reconnecter.", "error", "error");
                break;
        }

        return $messageBox->formatToHTML();
    }
}
