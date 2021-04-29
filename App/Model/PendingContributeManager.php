<?php

namespace App\Model;

use Exception;
use PDOException;
use App\PdoFactory;
use App\Model\Entity\Todo;
use App\Model\Entity\User;
use App\Model\Entity\PendingContribute;
use App\Model\Exceptions\DatabaseException;


/**
 * PendingContributeManager
 * Static class for loading PendingContribute.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class PendingContributeManager  
{
    /**
     * loadPendingContribute
     * Load all the PendingContribute of a user.
     *
     * @return void
     */
    public static function loadPendingContribute(User $userObject){
        $list_pendingContribute = array();
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT accepted_contribute, joindate_contribute, contribute.id_todo, title_todo, name_user FROM contribute, todo, user WHERE contribute.id_todo = todo.id_todo AND todo.id_user = user.id_user AND contribute.id_user = :id_user AND accepted_contribute = 0");
            $request->execute(array(':id_user' => $userObject->getId()));
            while ($result = $request->fetch()) {
                $pendingContribute = new PendingContribute($result["accepted_contribute"], $result["joindate_contribute"],$result["id_todo"], $result["title_todo"], $result["name_user"]);
                array_push($list_pendingContribute, $pendingContribute);
            }
        } catch (PDOException $e) {
            throw new DatabaseException($e->getCode());
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $list_pendingContribute;
    }

    public static function cancelPendingContribute(User $userObject, int $idTodo)
    {
        try{
            $request = PdoFactory::getPdo()->prepare("DELETE FROM contribute WHERE id_user = :id_user AND id_todo = :id_todo");
            $request->execute(array(':id_user' => $userObject->getId(), ':id_todo' => $idTodo));
        } catch (PDOException $e) {
            throw new DatabaseException($e->getCode());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
