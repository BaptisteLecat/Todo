<?php

namespace App\Model\Form\Sign;

use App\Model\SignInManager;

class SignIn extends Sign
{
    private $email;
    private $password;

    public function __construct(string $email, string $password)
    {
        parent::__construct();
        $this->email = $email;
        $this->password = $password;
        $this->signIn();
    }

    private function signIn()
    {
        $list_input = array("email" => $this->email, "password" => $this->password);

        if ($this->verifInput($list_input)) {
            SignInManager::verifLogin($this->email, $this->password);
        }
    }
}
