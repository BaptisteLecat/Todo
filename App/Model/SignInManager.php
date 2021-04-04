<?php

namespace App\Model;

use Exception;
use App\PdoFactory;
use App\Model\Entity\User;
use App\Model\Exceptions\SignException;
use PDOException;

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
        $request = PdoFactory::getPdo()->prepare("SELECT id_user FROM user WHERE email_user = :email_user and password_user = :password_user");
        if ($request->execute(array(':email_user' => $email, ':password_user' => $password))) {
            if ($request->rowCount() > 0) {
                $result = $request->fetch();
                $idUser = $result["id_user"];
            } else {
                throw new SignException(null);
            }
        }

        return $idUser;
    }
}
