<?php

namespace App\Model;

use Exception;
use App\PdoFactory;
use App\Model\Entity\User;
use PDOException;

/**
 * UserManager
 * Static class to manage the user.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class UserManager
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
}
