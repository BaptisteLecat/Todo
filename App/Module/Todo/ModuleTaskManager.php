<?php

namespace App\Module\Todo;

session_start();

use App\Loader;
use Exception;
use App\Model\TaskManager;

use App\Model\Exceptions\PermissionException;

/**
 * ModuleTaskManager
 * Cette classe permet de gerer les fonctionnalitées liés au tâches, dans une todo.
 */
class ModuleTaskManager
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

    public static function archiveTask($list_idTask, $idTodo)
    {
        self::loading();
        //Récupération de l'object associé à l'id todo passé en paramètre.
        $todoObject = self::getTodoObject($idTodo);

        /*
        Si on a un todoObject et que :
        - Le user est propriétaire de la Todo.
        OU
            - Le user à la permission nécessaire.
            ET
            - Le user est accepté au sein de cette Todo.
        */
        if ($todoObject != null && ($todoObject->getOwned() || ($todoObject->havePermissionTo(4) && self::$user->isAcceptedInTodo($todoObject)))) {
            //Parcours des idTask selectionné pour l'archivage.
            foreach ($list_idTask as $idTask) {
                //Comparaison avec chacune des task présente dans la todo.
                foreach ($todoObject->getList_Task() as $taskObject) {
                    if ($idTask == $taskObject->getId()) {
                        //Archivage
                        TaskManager::archiveTask(self::$user, $taskObject);
                        break;
                    }
                }
            }
        } else {
            throw new PermissionException(4);
        }
    }

    public static function achieveTask($idTask, $idTodo)
    {
        $task_return = null;

        self::loading();
        //Récupération de l'object associé à l'id todo passé en paramètre.
        $todoObject = self::getTodoObject($idTodo);

        /*
        Si on a un todoObject et que :
        - Le user est propriétaire de la Todo.
        OU
            - Le user à la permission nécessaire.
            ET
            - Le user est accepté au sein de cette Todo.
        */
        if ($todoObject != null && ($todoObject->getOwned() || ($todoObject->havePermissionTo(1) && self::$user->isAcceptedInTodo($todoObject)))) {
            //Comparaison avec chacune des task présente dans la todo.
            foreach ($todoObject->getList_Task() as $taskObject) {
                if ($idTask == $taskObject->getId()) {
                    //Archivage
                    TaskManager::achieveTask(self::$user, $taskObject);
                    $task_return = TaskManager::reloadTask($taskObject, self::$appObject->getList_Priority());
                    break;
                }
            }
        } else {
            throw new PermissionException(1);
        }

        return $task_return;
    }

    private static function getTodoObject($idTodo)
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
}
