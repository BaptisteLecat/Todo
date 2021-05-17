<?php

namespace App\Model\Form\Sign;

use App\Model\Form\Form;
use App\Model\SignInManager;
use App\Model\Exceptions\SignException;

class SignIn extends Form
{
    private $email;
    private $password;
    private $remember;

    public function __construct(string $email, string $password, bool $remember = null)
    {
        parent::__construct();
        $this->email = $email;
        $this->password = $password;
        $this->remember = (!is_null($remember)) ? true : false;
    }

    public function signIn()
    {
        $userObject = null;
        $list_input = array("email" => $this->email);

        if ($this->verifInput($list_input)) {
            $idUser = SignInManager::verifLogin($this->email, $this->hashPassword($this->password)); //HASH[5] == sha256
            if($idUser != null){
                $userObject = SignInManager::loadUser($idUser);
                //Cookies
                $this->rememberMe($idUser);
            }else{
                throw new SignException(null);
            }
        }

        return $userObject;
    }

    private function rememberMe(int $idUser){
        if($this->remember){
            $cookie = new Cookies($idUser);
            $cookie->generateLoginCookie();
        }
    }
}
