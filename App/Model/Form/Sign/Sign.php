<?php

namespace App\Model\Form\Sign;

use Error;

use Exception;
use App\Model\Exceptions\InputException;
use App\Model\XMLSettings\XMLInputSettings;
use App\Model\Exceptions\InputSignException;

class Sign
{
    protected $XMLInputSettingsObject;

    public function __construct()
    {
        try {
            $this->XMLInputSettingsObject = new XMLInputSettings("settings.xml", 0, true);
        } catch (Exception $e) {
            throw new Exception("Chargement de la configuration impossible.");
        }
    }

    protected function verifInput($list_input)
    {
        foreach (array_keys($list_input) as $inputTitle) {
            if (!is_null($list_input[$inputTitle])) {
                $this->checkInputSyntax($inputTitle, $list_input[$inputTitle]);
            } else {
                throw new InputException(0, $inputTitle);
            }
        }
    }

    private function checkInputSyntax($inputName, $value)
    {
        switch ($inputName) {
            case 'email':
                $emailSettings = $this->XMLInputSettingsObject->getEmailConfig();
                if (!empty($emailSettings)) {
                    if (!preg_match($emailSettings["regex"], $value)) {
                        throw new InputSignException(1);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'password':
                $passwordSettings = $this->XMLInputSettingsObject->getPasswordConfig();
                if (!empty($passwordSettings)) {
                    if (!preg_match($passwordSettings["regex"], $value)) {
                        throw new InputSignException(1);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            default:
                # code...
                break;
        }
    }
}
