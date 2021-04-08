<?php

namespace App\Model;

use Exception;
use App\PdoFactory;
use App\Model\Entity\User;
use App\Model\Exceptions\SignException;
use PDOException;

/**
 * SignInManager
 * Static class to manage the register.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class SignUpManager
{

    public static function emailIsValid(string $email)
    {
        $isValid = true;

        try {
            $request = PdoFactory::getPdo()->prepare("SELECT id_user FROM user WHERE email_user = :email_user");
            if ($request->execute(array(':email_user' => $email))) {
                if ($request->rowCount() > 0) {
                    $isValid = false;
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
        return $isValid;
    }

    public static function createAccount(string $name, string $firstname, string $email, string $password)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("INSERT INTO user (name_user, firstname_user, email_user, password_user) VALUES (:name_user, :firstname_user, :email_user, :password_user)");
            $request->execute(array(':name_user' => $name, ':firstname_user' => $firstname, ':email_user' => $email, ':password_user' => $password));
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
