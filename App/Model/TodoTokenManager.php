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
    public static function loadTokenFromTodo(Todo $todoObject){
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT expirationdate, id_permission FROM todo_token WHERE id_todo = :id_todo");
            $request->execute(array(':id_todo' => $todoObject->getId()));
            $result = $request->fetch();
            $list_permission = PermissionManager::loadPermission();
            foreach ($list_permission as $permission) {
                if($permission->getId() == $result["id_permission"]){
                    $todoToken = new TodoToken($result["expirationdate"], $permission, $todoObject);
                    break;
                }
            }
        }catch(Exception $e){
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
     * @param  mixed $userObject
     * @param  mixed $permissionObject
     * @param  mixed $todoObject
     * @return void
     */
    public static function createToken(User $userObject, Permission $permissionObject, Todo $todoObject){
        try{
            $request = PdoFactory::getPdo()->prepare("INSERT INTO todo_token VALUES (:token, DATE_ADD(NOW(), INTERVAL 10 DAY), :id_permission, :id_todo)");
            $request->execute(array(':token' => self::tokenGenerator(), ':id_permission' => $permissionObject->getId(), ':id_todo' => $todoObject->getId()));
            self::loadTokenFromTodo($todoObject);
        }catch(Exception $e){
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
