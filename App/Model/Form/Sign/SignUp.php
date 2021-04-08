<?php

namespace App\Model\Form\Sign;

use App\Model\Exceptions\InputSignException;
use Exception;
use PDOException;
use App\Model\UserManager;
use App\Model\SignInManager;
use App\Model\Exceptions\SignException;
use App\Model\SignUpManager;

class SignUp extends Sign
{
    private $name;
    private $firstName;
    private $email;
    private $password;

    public function __construct(string $name, string $firstName)
    {
        parent::__construct();
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = null;
        $this->password = null;

        $this->step = 1;
    }

    public function __sleep()
    {
        return array('name', 'firstName');
    }

    public function __wakeup()
    {
        parent::__construct();
    }

    public function validFirstStep()
    {
        $success = false;
        $list_input = array("name" => $this->name, "firstName" => $this->firstName);
        if($this->verifInput($list_input)){
            $success = true;
        }

        return $success;
    }

    public function signUp(string $email, string $password)
    {
        $success = false;
        $list_input = array("name" => $this->name, "firstName" => $this->firstName, "email" => $email, "password" => $password);

        if ($this->verifInput($list_input)) {
            if(SignUpManager::emailIsValid($email)){
                SignUpManager::createAccount($this->name, $this->firstName, $email, $password);
                $success = true;
            }else{
                throw new SignException(1);
            }
        }

        return $success;
    }
}
