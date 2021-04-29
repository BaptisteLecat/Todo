<?php

namespace App\Model\Form\Sign;

use Exception;
use App\Model\Exceptions\InputException;
use App\Model\XMLSettings\XMLInputSettings;
use App\Model\Exceptions\InputSignException;

class Sign
{
    protected $inputSettings;

    public function __construct()
    {
        $this->inputSettings = new XMLInputSettings("../App/Settings/input.xml", null, true);
    }

    public function __sleep()
    {
        return array();
    }

    protected function verifInput($list_input)
    {
        $success = false;
        foreach (array_keys($list_input) as $inputTitle) {
            if (!is_null($list_input[$inputTitle])) {
                $this->checkInputSyntax($inputTitle, $list_input[$inputTitle]);
                $success = true;
            } else {
                throw new InputException(0, $inputTitle);
            }
        }

        return $success;
    }

    private function checkInputSyntax($inputName, $value)
    {
        switch ($inputName) {
            case 'email':
                $emailSettings = $this->inputSettings->getEmailConfig();
                if (!empty($emailSettings)) {
                    if (!preg_match($emailSettings["regex"], $value)) {
                        throw new InputSignException(1);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'password':
                $passwordSettings = $this->inputSettings->getPasswordConfig();
                if (!empty($passwordSettings)) {
                    if (strlen($value) < $passwordSettings["minLength"]) {
                        throw new InputSignException(2);
                    }
                } else {
                    throw new Exception("Chargement de la configuration impossible.");
                }
                break;

            case 'name':

                break;

            case 'firstName':

                break;

            default:
                throw new Exception("Champs inconnu.");
                break;
        }
    }
}
