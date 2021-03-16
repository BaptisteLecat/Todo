<?php

namespace App\Model;

use Exception;
use App\PdoFactory;
use App\Model\Entity\Todo;
use App\Model\Entity\Contribute;
use App\Model\Entity\User;

class ContributeManager
{
    public static function loadTodoContribute(User $userObject, $list_TodoIcon, $list_permission)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("call selectTodoContribute(:id_user)");
            $request->execute(array(':id_user' => $userObject->getId()));
            $request = PdoFactory::getPdo()->prepare("SELECT * FROM TMP_TODOCONTRIBUTE");
            $request->execute();
            while ($result = $request->fetch()) {
                $todo = self::loadTodoFromId($result["_id_todo"], $userObject, $list_TodoIcon);
                foreach ($list_permission as $permission) {
                    if($permission->getId() == $result["_id_permission"]){
                        
                        $contribute = new Contribute($result["_accepted_contribute"], $result["_joindate_contribute"], $permission, $userObject, $todo); 
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    private static function loadTodoFromId(int $idTodo, User $userObject, $list_TodoIcon)
    {
        $todo = null;

        try {
            $request = PdoFactory::getPdo()->prepare("SELECT title_todo, description_todo, createdate_todo, id_icon FROM todo WHERE id_todo = :id_todo");
            $request->execute(array(':id_todo' => $idTodo));

            while ($result = $request->fetch()) {
                foreach ($list_TodoIcon as $todoIconObject) {
                    if ($todoIconObject->getId() == $result["id_icon"]) {
                        $todo = new Todo($idTodo, $result["title_todo"], $result["description_todo"], $result["createdate_todo"], $userObject, $todoIconObject, false);
                        break;
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $todo;
    }
}
