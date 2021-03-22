<?php

namespace App\Model\Exceptions;

use App\Model\Exceptions\MessageBox;

class SuccessManager extends MessageBox
{
    public function __construct(string $message, string $icon = null)
    {
        parent::__construct($message, $icon, "success");
    }

    public function __toString()
    {
        return parent::formatToHTML();
    }
}
