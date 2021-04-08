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

    /**
     * loadUser
     * Select user informations and create UserObject.
     *
     * @param  int $idUser
     * @return User $user
     */
    public static function loadUser(int $idUser)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT name_user, firstname_user, email_user, password_user, createdate_user FROM user WHERE id_user = :id_user");
            $request->execute(array(':id_user' => $idUser));
            $result = $request->fetch();
            $user = new User($idUser, $result["name_user"], $result["firstname_user"], $result["email_user"], $result["password_user"], $result["createdate_user"]);
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $user;
    }

    public static function verifLogin($email, $password)
    {
        try {
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
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $idUser;
    }
}
