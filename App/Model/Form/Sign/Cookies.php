<?php

namespace App\Model\Form\Sign;

use App\Model\RememberManager;
use App\Model\SignInManager;

class Cookies
{
    private $identifier;
    private $token;
    private $idUser;
    private $cookieName;

    public function __construct(int $idUser = null)
    {
        $this->identifier = null;
        $this->token = null;
        $this->idUser = $idUser;
        $this->cookieName = "todoLogin";
    }

    public function generateLoginCookie()
    {
        $this->identifier = hash(hash_algos()[5], time());
        $this->token = hash(hash_algos()[5], time());
        
        if (!is_null($this->idUser)) {
            RememberManager::insertRemember($this->identifier, $this->token, $this->idUser);
            $data = ["identifier" => $this->identifier, "token" => $this->token];
            setcookie($this->cookieName, json_encode($data), time() + (3600 * 24 * 30), "", "", false, true);
        } else {
            //TODO throw error.
        }
    }

    public function verifLoginCookie()
    {
        $userObject = null;

        if(isset($_COOKIE[$this->cookieName])){
            $data = json_decode($_COOKIE[$this->cookieName], true);
            $args = array(
                'identifier' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'token' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
            );
            $filtered_var = filter_var_array($data, $args);
            $this->idUser = RememberManager::verifRemember($filtered_var["identifier"], $filtered_var["token"]);
            $userObject = SignInManager::loadUser($this->idUser);
        }

        return $userObject;
    }
}
