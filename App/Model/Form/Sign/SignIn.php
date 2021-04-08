<?php

namespace App\Model\Form\Sign;

use App\Model\Exceptions\InputSignException;
use Exception;
use PDOException;
use App\Model\UserManager;
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
        $userObject = null;
        $list_input = array("email" => $this->email);

        if ($this->verifInput($list_input)) {
            $idUser = SignInManager::verifLogin($this->email, $this->password);
            $userObject = SignInManager::loadUser($idUser);
        }

        return $userObject;
    }
}
