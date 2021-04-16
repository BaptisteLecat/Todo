<?php

namespace App\Module\Home;

session_start();

use Exception;
use App\Loader;

use App\Model\Entity\Todo;
use App\Model\TaskManager;
use App\Model\ContributeManager;
use App\Model\Exceptions\PermissionException;

/**
 * ModuleHome
 * Cette classe permet de gerer les fonctionnalitées liés au tâches, dans une todo.
 */
class ModuleHome
{
    private static $user;
    private static $appObject;

    private static function loading()
    {
        self::$appObject = unserialize($_SESSION["App"]);

        self::$user = unserialize($_SESSION["User"]);
        Loader::LoadUser(self::$user, self::$appObject->getList_TodoIcon(), self::$appObject->getList_Priority());
        Loader::loadContribute(self::$user, self::$appObject->getList_TodoIcon(), self::$appObject->getList_Permission(), self::$appObject->getList_Priority());
    }

    public static function achieveTask($idTask)
    {
        self::loading();
        //Récupération de l'object associé à l'id task passé en paramètre.
        $taskObject = self::getTaskObject($idTask);
        $todoObject = $taskObject->getTodoObject();

        /*
        Si on a un todoObject et que :
        - Le user est propriétaire de la Todo.
        OU
            - Le user à la permission nécessaire.
            ET
            - Le user est accepté au sein de cette Todo.
        */
        if ($todoObject != null && ($todoObject->getOwned() || ($todoObject->havePermissionTo(1) && self::$user->isAcceptedInTodo($todoObject)))) {
            //Achieve
            TaskManager::achieveTask(self::$user, $taskObject);
        } else {
            throw new PermissionException(1);
        }
    }

    private static function getTaskObject(int $idTask)
    {
        $taskObject = null;
        $isFinded = false;
        foreach (self::$user->getList_Task() as $task) {
            if ($task->getId() == $idTask) {
                $taskObject = $task;
                $isFinded = true;
                break;
            }
        }

        if (!$isFinded) {
            foreach (self::$user->getList_TodoContribute() as $todoContribute) {
                if (!$isFinded) {
                    foreach ($todoContribute->getList_Task() as $taskContribute) {
                        if ($taskContribute->getId() == $idTask) {
                            $taskObject = $task;
                            $isFinded = true;
                            break;
                        }
                    }
                }
            }
        }
        return $taskObject;
    }

    private static function getTodoObject(int $idTodo)
    {
        $todoObject = null;
        $isFinded = false;
        foreach (self::$user->getList_Todo() as $todo) {
            if ($todo->getId() == $idTodo) {
                $todoObject = $todo;
                $isFinded = true;
                break;
            }
        }

        if (!$isFinded) {
            foreach (self::$user->getList_TodoContribute() as $todo) {
                if ($todo->getId() == $idTodo) {
                    $todoObject = $todo;
                    break;
                }
            }
        }
        return $todoObject;
    }

    private static function getContributorObject(int $idUser, Todo $todoObject)
    {
        $userObject = null;

        $list_contributor = ContributeManager::loadUsersOfTodo($todoObject, self::$appObject->getList_Permission());

        foreach ($list_contributor as $contributor) {
            if ($contributor->getId() == $idUser) {
                $userObject = $contributor;
                break;
            }
        }

        return $userObject;
    }

    private static function getPermissionObject(int $idPermission)
    {
        $permissionObject = null;

        foreach (self::$appObject->getList_Permission() as $permission) {
            if ($permission->getId() == $idPermission) {
                $permissionObject = $permission;
                break;
            }
        }

        return $permissionObject;
    }
}
