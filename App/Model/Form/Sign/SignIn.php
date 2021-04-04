<?php

namespace App\Model\Form\Sign;

use Exception;
use PDOException;
use App\Model\SignInManager;
use App\Model\Exceptions\SignException;

class SignIn extends Sign
{
    private $email;
    private $password;

    public function __construct(string $email, string $password)
    {
        parent::__construct();
        $this->email = $email;
        $this->password = $password;
    }

    public function signIn()
    {
        $idUser = null;
        $list_input = array("email" => $this->email);

        if ($this->verifInput($list_input)) {
            $idUser = SignInManager::verifLogin($this->email, $this->password);
        }

        return $idUser;
    }
}
