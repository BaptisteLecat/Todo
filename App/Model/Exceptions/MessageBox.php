<?php

namespace App\Model\Exceptions;

/**
 * MessageBox
 * Cette classe permet de générer une messageBox.
 */
class MessageBox
{
    protected $message;
    protected $icon;
    protected $level;


    /**
     * __construct
     *
     * @param  string $message
     * @param  string $icon
     * @param  string $level niveau / type de l'exception.
     * @return void
     */
    function __construct(string $message, string $icon = null, string $level = null)
    {
        $this->message = $message;
        $this->icon = $icon;
        $this->level = $level;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function formatToHTML()
    {

        switch ($this->level) {
            case 'error':
                require(__DIR__ . "/../../../view/messageBox/error.php");
                break;

            case 'success':
                require(__DIR__ . "/../../../view/messageBox/success.php");
                break;

            default:
                require(__DIR__ . "/../../../view/messageBox/error.php");
                break;
        }

        return $messageHTML;
    }
}
