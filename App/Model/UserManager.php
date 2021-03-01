<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\User;
use Exception;

/**
 * UserManager
 * Static class for CRUD User requests.
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
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT name_user, firstname_user, email_user, password_user, createdate_user FROM user WHERE id_user = :id_user");
            $request->execute(array(':id_user' => $idUser));
            $result = $request->fetch();
            $user = new User($idUser, $result["name_user"], $result["firstname_user"], $result["email_user"], $result["password_user"], $result["createdate_user"]);
        }catch(Exception $e){
            throw new Exception($e);
        }

        return $user;
    }
    
    /**
     * insertUser
     * Insert a new User in database.
     * 
     * @param  string $name
     * @param  string $firstname
     * @param  string $email
     * @param  string $password
     * @return User $user
     */
    public static function insertUser(string $name, string $firstname, string $email, string $password){
        try{
            $request = PdoFactory::getPdo()->prepare("INSERT INTO user (name_user, firstname_user, email_user, password_user) VALUES (:name_user, :firstname_user, :email_user, :password_user)");
            $request->execute(array(':name_user' => $name, ':firstname_user' => $firstname, ':email_user' => $email, ':password_user' => $password));
            $user = self::loadUser(PdoFactory::getPdo()->lastInsertId());
        }catch(Exception $e){
            throw new Exception($e);
        }

        return $user;
    }
    
    /**
     * updateUser
     * Update the value of a specified attribute.
     *
     * @param  string $attribute
     * @param  string $value
     * @param  User $userObject
     * @return void
     */
    public static function updateUser(string $attribute, string $value, User $userObject){

        try{
            switch ($attribute) {
                case 'name_user':
                    $request = PdoFactory::getPdo()->prepare("UPDATE user SET name_user = :name_user WHERE id_user = :id_user");
                    $request->execute(array(':name_user' => $value, 'id_user' => $userObject->getId()));
                    $userObject->setName($value);
                    break;

                case 'firstname_user':
                    $request = PdoFactory::getPdo()->prepare("UPDATE user SET firstname_user = :firstname_user WHERE id_user = :id_user");
                    $request->execute(array(':firstname_user' => $value, 'id_user' => $userObject->getId()));
                    $userObject->setFirstName($value);
                    break;

                case 'email_user':
                    $request = PdoFactory::getPdo()->prepare("UPDATE user SET email_user = :email_user WHERE id_user = :id_user");
                    $request->execute(array(':email_user' => $value, 'id_user' => $userObject->getId()));
                    $userObject->setEmail($value);
                    break;

                case 'password_user':
                    $request = PdoFactory::getPdo()->prepare("UPDATE user SET password_user = :password_user WHERE id_user = :id_user");
                    $request->execute(array(':password_user' => $value, 'id_user' => $userObject->getId()));
                    break;
                
                default:
                    # code...
                    break;
            }

        }catch(Exception $e){
            throw new Exception($e);
        }
    }

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

    public static function emailIsValid($email)
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

    public static function createAccount($name, $firstname, $email, $password)
    {
        $user = null;

        try {
            $request = PdoFactory::getPdo()->prepare("INSERT INTO user (name_user, firstname_user, email_user, password_user) VALUES (:name_user, :firstname_user, :email_user, :password_user)");
            if ($request->execute(array(':name_user' => $name, ':firstname_user' => $firstname, ':email_user' => $email, ':password_user' => $password))) {
                $id = $this->pdo->lastInsertId();
                $user = self::loadUser(PdoFactory::getPdo()->lastInsertId());
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
        return $user;
    }
}
