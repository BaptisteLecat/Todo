<?php

namespace App\Model\Exceptions;

use App\Model\XMLSettings\XMLErrorDatabase;
use Exception;

class DatabaseException extends Exception
{
    private $errorDatabase;

    public function __construct(int $code = null)
    {
        parent::__construct("", $code);
        $this->errorDatabase = new XMLErrorDatabase($_SERVER['DOCUMENT_ROOT'] . "/../App/Settings/errorDatabase.xml", null, true);
    }

    public function __toString()
    {
        //Default value.
        $messageBox = new MessageBox("Erreur lors de la procédure.", "error", "error");

        foreach ($this->errorDatabase as $error) {
            if($error->code == $this->code){
                $messageBox = new MessageBox($error->content, "error", "error");
            }
        }

        return $messageBox->formatToHTML();
    }
}
