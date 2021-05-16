<?php

namespace App\Model\Form\Sign;

use App\Model\Form\Form;
use App\Model\SignInManager;
use App\Model\Exceptions\SignException;

class SignIn extends Form
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
            $idUser = SignInManager::verifLogin($this->email, $this->hashPassword($this->password)); //HASH[5] == sha256
            if($idUser != null){
                $userObject = SignInManager::loadUser($idUser);
                //Create cookies
            }else{
                throw new SignException(null);
            }
        }

        return $userObject;
    }
}
