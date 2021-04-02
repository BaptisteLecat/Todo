<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\User;
use Exception;

/**
 * SignInManager
 * Static class to manage the login.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class SignInManager
{

    public static function verifLogin($email, $password)
    {
        $idUser = null;

        try {
            $request = PdoFactory::getPdo()->prepare("SELECT id_user FROM user WHERE email_user = :email_user and password_user = :password_user");
            if ($request->execute(array(':email_user' => $email, ':password_user' => $password))) {
                if ($request->rowCount() > 0) {
                    $result = $request->fetch();
                    $idUser = $result["id_user"];
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $idUser;
    }
}
