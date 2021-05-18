<?php

namespace App\Model\Form\Sign;

use App\Model\Exceptions\CookieException;
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
        $this->identifier = bin2hex(openssl_random_pseudo_bytes(16));
        $this->token = bin2hex(openssl_random_pseudo_bytes(24));
        /*$this->identifier = hash(hash_algos()[5], time());
        $this->token = hash(hash_algos()[5], time());*/
        
        if (!is_null($this->idUser)) {
            RememberManager::insertRemember(hash(hash_algos()[5], $this->identifier), hash(hash_algos()[5], $this->token), $this->idUser);
            $data = ["identifier" => $this->identifier, "token" => $this->token];
            setcookie($this->cookieName, json_encode($data), time() + (3600 * 24 * 30), "", "", false, true);
        } else {
            throw new CookieException(1);
        }
    }

    public function verifLoginCookie()
    {
        $userObject = null;
        if(isset($_COOKIE[$this->cookieName])){
            //On récupère les data du cookie.
            $data = json_decode($_COOKIE[$this->cookieName], true);
            $args = array(
                'identifier' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'token' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
            );
            $filtered_var = filter_var_array($data, $args);
            $this->identifier = $filtered_var["identifier"];
            $this->token = $filtered_var["token"];
            //On authentifie le user grâce au cookie.
            $this->idUser = RememberManager::verifRemember(hash(hash_algos()[5], $this->identifier), hash(hash_algos()[5], $this->token));
            if(!is_null($this->idUser)){
                $userObject = SignInManager::loadUser($this->idUser);
            }else{
                //Suppression du cookie. Et des infos potentiellement correspondante au token et à l'identifier dans la base.
                setcookie($this->cookieName, '', time() -3600, "", "", false, true);
                RememberManager::deleteRemember($this->identifier, $this->token);
                throw new CookieException(2);
            }
        }
        return $userObject;
    }
}
