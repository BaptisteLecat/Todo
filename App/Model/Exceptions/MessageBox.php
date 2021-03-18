<?php

namespace App\Model\Exceptions;

class MessageBox
{
    private $color;
    private $icon;

    private $level;

    function __construct($color = null, $icon = null, $level = null)
    {
        $this->color = $color;
        $this->icon = $icon;
        $this->level = $level;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function formatToHTML($errorMessage){

        require(__DIR__. "/../../../view/messageBox/information.php");

        return $messageHTML;
    }
}
