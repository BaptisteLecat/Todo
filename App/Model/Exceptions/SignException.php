<?php

namespace App\Model\Exceptions;

use Exception;

class SignException extends Exception
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
            default:
                $messageBox = new MessageBox("Identifiants incorrects.", "error", "error");
                break;
        }

        return $messageBox->formatToHTML();
    }
}
