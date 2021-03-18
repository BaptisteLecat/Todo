<?php

namespace App\Model\Exceptions;

class MessageBox
{
    private $title;
    private $message;
    private $icon;

    private $level;

    function __construct($title, $message, $icon = null, $level = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
        $this->level = $level;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getColor()
    {
        //En fonction du level, dois retourné la couleur configurée.
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function formatToHTML(){

        require(__DIR__. "/../../../view/messageBox/information.php");

        return $messageHTML;
    }
}
