<?php

namespace App\Form;

use App\Model\Exceptions\InputException;

class Sign
{
    public function __construct()
    {
    }

    public function verifInput($list_input)
    {
        foreach (array_keys($list_input) as $inputTitle) {
            if (is_null($list_input[$inputTitle])) {
                throw new InputException(0, $inputTitle);
            }
        }
    }

    public function checkInputSyntax($inputName, $value){
        switch ($variable) {
            case 'value':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }
}
