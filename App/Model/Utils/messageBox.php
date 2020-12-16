<?php

namespace App\Model\Utils;

class MessageBox
{
    private $message;
    private $icon;

    function __construct($message, $icon)
    {
        $this->message = $message;
        $this->icon = $icon;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setMessage()
    {
        return $this->message;
    }

    public function setIcon()
    {
        return $this->icon;
    }
}
