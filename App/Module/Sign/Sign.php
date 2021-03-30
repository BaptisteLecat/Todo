<?php

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
}
