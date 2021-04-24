<?php

namespace App\Module\Home;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    public static function getUserObject()
    {
        return self::$user;
    }

    private static function loading()
    {
        self::$appObject = unserialize($_SESSION["App"]);

        self::$user = unserialize($_SESSION["User"]);
        Loader::LoadUser(self::$user, self::$appObject->getList_TodoIcon(), self::$appObject->getList_Priority());
        Loader::loadContribute(self::$user, self::$appObject->getList_TodoIcon(), self::$appObject->getList_Permission(), self::$appObject->getList_Priority());
    }

    public static function achieveTask($idTask)
    {
        $todoObject = null;
        self::loading();
        //Récupération de l'object associé à l'id task passé en paramètre.
        $taskObject = self::getTaskObject($idTask);
        if ($taskObject != null) {
            $todoObject = $taskObject->getTodoObject();
        } else {
            throw new Exception("Cette tâche est inconnue");
        }


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

    public static function taskForToday($list_task, $dateSet = null)
    {
        $listTaskToday = array();
        $date = is_null($dateSet) ? date("Y-m-d") : $dateSet;
        foreach ($list_task as $task) {
            if ($task->getEndDate() == $date) {
                array_push($listTaskToday, $task);
            }
        }
        return $listTaskToday;
    }

    public static function nbTaskValidate($list_task)
    {
        $nbTaskValidate = 0;
        foreach ($list_task as $task) {
            if ($task->isAchieve()) {
                $nbTaskValidate++;
            }
        }
        return round($nbTaskValidate);
    }

    public static function progressValuePercentToday($list_task)
    {
        $progressValue = 0;
        if (count($list_task) > 0) {
            $nbTaskAchieve = 0;
            foreach ($list_task as $task) {
                if ($task->isAchieve()) {
                    $nbTaskAchieve++;
                }
            }
            $progressValue = ($nbTaskAchieve / count($list_task)) * 100;
        }

        return round($progressValue);
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
