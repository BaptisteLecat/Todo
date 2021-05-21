<?php

namespace App\Model;

use Exception;
use App\PdoFactory;
use App\Model\Entity\Todo;
use App\Model\Entity\User;
use App\Model\Entity\Contribute;
use App\Model\Entity\Permission;
use App\Model\Entity\UserContributor;

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
                    if ($permission->getId() == $result["_id_permission"]) {
                        $contribute = new Contribute($result["_accepted_contribute"], $result["_joindate_contribute"], $permission, $userObject, $todo);
                        break;
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
            $request = PdoFactory::getPdo()->prepare("SELECT title_todo, description_todo, createdate_todo, id_icon, id_user FROM todo WHERE id_todo = :id_todo");
            $request->execute(array(':id_todo' => $idTodo));
            while ($result = $request->fetch()) {
                foreach ($list_TodoIcon as $todoIconObject) {
                    if ($todoIconObject->getId() == $result["id_icon"]) {
                        //Chargement de l'object user du propriétaire.
                        $userOwner = UserManager::loadUser($result["id_user"]);
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

    public static function insertContribute(UserContributor $userContributor, Todo $todoObject, Permission $permissionObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("INSERT INTO contribute (id_user, id_todo, id_permission, accepted_contribute) VALUES (:id_user, :id_todo, :id_permission, 1)");
            $request->execute(array(':id_user' => $userContributor->getId(), ':id_todo' => $todoObject->getId(), 'id_permission' => $permissionObject->getId()));
            $userContributor->addPermission($permissionObject);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function deleteContribute(UserContributor $userContributor, Todo $todoObject, Permission $permissionObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("DELETE FROM contribute WHERE id_user = :id_user AND id_todo = :id_todo AND id_permission = :id_permission");
            $request->execute(array(':id_user' => $userContributor->getId(), ':id_todo' => $todoObject->getId(), 'id_permission' => $permissionObject->getId()));
            $userContributor->removePermission($permissionObject);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function refuseContributor(UserContributor $userContributor, Todo $todoObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("DELETE FROM contribute WHERE id_user = :id_user AND id_todo = :id_todo");
            $request->execute(array(':id_user' => $userContributor->getId(), ':id_todo' => $todoObject->getId()));
            unset($userContributor);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function acceptContributor(UserContributor $userContributor, Todo $todoObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("UPDATE contribute SET accepted_contribute = 1 WHERE id_user = :id_user AND id_todo = :id_todo");
            $request->execute(array(':id_user' => $userContributor->getId(), ':id_todo' => $todoObject->getId()));
            $userContributor->setAccepted(1);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function loadUsersOfTodo(Todo $todoObject, $list_permission)
    {
        $list_userContributor = array();

        try {
            $request = PdoFactory::getPdo()->prepare("SELECT user.id_user, name_user, firstname_user, email_user, joindate_contribute, contribute.accepted_contribute, contribute.id_permission FROM contribute, user WHERE contribute.id_user = user.id_user and contribute.id_todo = :id_todo");
            $request->execute(array(":id_todo" => $todoObject->getId()));
            while ($result = $request->fetch()) {
                $isFinded = false;
                foreach ($list_userContributor as $user) {
                    if ($user->getId() == $result["id_user"]) {
                        foreach ($list_permission as $permission) {
                            if ($permission->getId() == $result["id_permission"]) {
                                $user->addPermission($permission);
                                break;
                            }
                        }
                        $isFinded = true;
                        break;
                    }
                }

                if (!$isFinded) {
                    $userContributor = new UserContributor($result["id_user"], $result["name_user"], $result["firstname_user"], $result["email_user"], $result["joindate_contribute"], $result["accepted_contribute"]);
                    foreach ($list_permission as $permission) {
                        if ($permission->getId() == $result["id_permission"]) {
                            $userContributor->addPermission($permission);
                            break;
                        }
                    }
                    array_push($list_userContributor, $userContributor);
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $list_userContributor;
    }
}
