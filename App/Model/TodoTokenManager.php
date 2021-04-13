<?php

namespace App\Model;

use Exception;
use App\Model\Entity\Permission;
use App\Model\Entity\Todo;
use App\Model\Entity\TodoToken;
use PDOException;
use App\Model\Entity\User;
use App\PdoFactory;

/**
 * TodoTokenManager
 * Static class for todoToken operations.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class TodoTokenManager
{
    /**
     * loadTokenFromTodo
     * Load the todoToken list of a todo.
     * Called for displaying the token created for a todo.
     *
     * @param  mixed $todoObject
     * @return void
     */
    public static function loadTokenFromTodo(Todo $todoObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT token, expirationdate, id_permission FROM todo_token WHERE id_todo = :id_todo ORDER BY expirationdate ASC");
            $request->execute(array(':id_todo' => $todoObject->getId()));
            while ($result = $request->fetch()) {
                $list_permission = PermissionManager::loadPermission();
                foreach ($list_permission as $permission) {
                    if ($permission->getId() == $result["id_permission"]) {
                        $todoToken = new TodoToken($result["token"], $result["expirationdate"], $permission, $todoObject);
                        break;
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * loadTokenFromToken
     * Load the todoToken from a token string.
     *
     * @param  string $token
     * @param  Todo $todoObject
     * @return void
     */
    public static function loadTokenFromToken(string $token, Todo $todoObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT token, expirationdate, id_permission FROM todo_token WHERE token = :token");
            $request->execute(array(':token' => $token));
            $result = $request->fetch();
            $list_permission = PermissionManager::loadPermission();
            foreach ($list_permission as $permission) {
                if ($permission->getId() == $result["id_permission"]) {
                    $todoToken = new TodoToken($result["token"], $result["expirationdate"], $permission, $todoObject);
                    break;
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * submitToken
     * Call the procedure to check a token, and add the user to the todo.
     *
     * @param  mixed $token
     * @param  mixed $userObject
     * @return void
     */
    public static function submitToken(string $token, User $userObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("call processCheckToken(:p_Token, :p_idUser)");
            $request->execute(array(':p_Token' => $token, ':p_idUser' => $userObject->getId()));
            //TODO appel fonction dans user pour voir les todo en attente d'acceptation.
        } catch (PDOException $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * createToken
     * Generate a new token to invite someone to his todo.
     *
     * @param  mixed $permissionObject
     * @param  mixed $todoObject
     * @return void
     */
    public static function createToken(Permission $permissionObject, Todo $todoObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("INSERT INTO todo_token VALUES (:token, DATE_ADD(NOW(), INTERVAL 10 DAY), :id_permission, :id_todo)");
            $request->execute(array(':token' => self::tokenGenerator(), ':id_permission' => $permissionObject->getId(), ':id_todo' => $todoObject->getId()));
            self::loadTokenFromTodo($todoObject);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * deleteToken
     * Delete a token in reference to the todo.
     *
     * @param  TodoToken $tokenObject
     * @return void
     */
    public static function deleteToken(TodoToken $tokenObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("DELETE FROM todo_token WHERE token = :token");
            $request->execute(array(':token' => $tokenObject->getToken()));
            $tokenObject->delete();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * regenerateToken
     * Refresh a token and generate an other token string.
     *
     * @param  TodoToken $tokenObject
     * @return void
     */
    public static function regenerateToken(TodoToken $tokenObject)
    {
        try {
            $newToken = self::tokenGenerator();
            $request = PdoFactory::getPdo()->prepare("UPDATE todo_token SET token = :newToken, expirationdate = DATE_ADD(NOW(), INTERVAL 10 DAY) WHERE token = :token");
            $request->execute(array(':newToken' => $newToken, ':token' => $tokenObject->getToken()));
            self::loadTokenFromToken($newToken, $tokenObject->getTodoObject());
            $tokenObject->delete();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * tokenGenerator
     * Generate a 6 chars token.
     *
     * @param  mixed $length
     * @return void
     */
    private static function tokenGenerator($length = 6)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }
}
