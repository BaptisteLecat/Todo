<?php

namespace App\Model;

use Exception;
use PDOException;
use App\PdoFactory;
use App\Model\Entity\User;
use App\Model\Exceptions\SignException;
use App\Model\Exceptions\DatabaseException;

/**
 * RememberManager
 * Static class to manage the remember on login.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class RememberManager
{

    public static function verifRemember(string $identifier, string $token)
    {
        try {
            $idUser = null;
            $request = PdoFactory::getPdo()->prepare("SELECT id_user FROM remember_user WHERE identifier = :identifier and token = :token");
            if ($request->execute(array(':identifier' => $identifier, ':token' => $token))) {
                if ($request->rowCount() > 0) {
                    $result = $request->fetch();
                    $idUser = $result["id_user"];
                }
            }
        } catch (PDOException $e) {
            throw new DatabaseException($e->getCode());
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $idUser;
    }

    public static function insertRemember(string $identifier, string $token, int $idUser)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("INSERT INTO remember_user (identifier, token, id_user) VALUES (:identifier, :token, :id_user)");
            $request->execute(array(':identifier' => $identifier, ':token' => $token, ':id_user' => $idUser));
        } catch (PDOException $e) {
            throw new DatabaseException($e->getCode());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function deleteRemember(string $identifier, string $token)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("DELETE FROM remember_user WHERE identifier = :identifier or token = :token");
            $request->execute(array(':identifier' => $identifier, ':token' => $token));
        } catch (PDOException $e) {
            throw new DatabaseException($e->getCode());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
