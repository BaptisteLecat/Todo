<?php

namespace App\Module;

session_start();

use Exception;
use App\Model\TaskManager;
use App\Model\ContributeManager;

use App\Model\Exceptions\PermissionException;

class ModuleTaskManager
{
    private static $userObject;
    private static $appObject;

    public static function archiveTask($list_idTask, $idTodo)
    {
        $task_return = null;

            self::$userObject = unserialize($_SESSION["User"]);
            self::$appObject = unserialize($_SESSION["App"]);
            //Récupération de l'object associé à l'id todo passé en paramètre.
            $todoObject = self::getTodoObject($idTodo);

            if ($todoObject != null && ($todoObject->havePermissionTo(4) || $todoObject->getOwned())) {
                //Parcours des idTask selectionné pour l'archivage.
                foreach ($list_idTask as $idTask) {
                    //Comparaison avec chacune des task présente dans la todo.
                    foreach ($todoObject->getList_Task() as $taskObject) {
                        if ($idTask == $taskObject->getId()) {
                            //Archivage
                            TaskManager::archiveTask(self::$userObject, $taskObject);
                            $task_return = $taskObject;
                            break;
                        }
                    }
                }
            } else {
                throw new PermissionException(4);
            }

            return $task_return;
    }

    public static function achieveTask($idTask, $idTodo)
    {
        $task_return = null;

            self::$userObject = unserialize($_SESSION["User"]);
            self::$appObject = unserialize($_SESSION["App"]);
            //Récupération de l'object associé à l'id todo passé en paramètre.
            $todoObject = self::getTodoObject($idTodo);

            if ($todoObject != null && ($todoObject->havePermissionTo(1) || $todoObject->getOwned())) {
                //Comparaison avec chacune des task présente dans la todo.
                foreach ($todoObject->getList_Task() as $taskObject) {
                    if ($idTask == $taskObject->getId()) {
                        //Archivage
                        TaskManager::achieveTask(self::$userObject, $taskObject);
                        TaskManager::reloadTask($taskObject, self::$appObject->getList_Priority());
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
        self::loadUserTodoContribute(self::$userObject, self::$appObject->getList_TodoIcon(), self::$appObject->getList_Permission());
        self::loadTodoContributeTask(self::$userObject, self::$appObject->getList_Priority());

        $todoObject = null;
        $isFinded = false;
        foreach (self::$userObject->getList_Todo() as $todo) {
            if ($todo->getId() == $idTodo) {
                $todoObject = $todo;
                $isFinded = true;
                break;
            }
        }

        if (!$isFinded) {
            foreach (self::$userObject->getList_TodoContribute() as $todo) {
                if ($todo->getId() == $idTodo) {
                    $todoObject = $todo;
                    break;
                }
            }
        }
        return $todoObject;
    }

    private static function loadUserTodoContribute($user, $list_todoIcon, $list_permission)
    {
        try {
            ContributeManager::loadTodoContribute($user, $list_todoIcon, $list_permission);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    private static function loadTodoContributeTask($user, $list_priority)
    {
        try {
            foreach ($user->getList_TodoContribute() as $todoContribute) {
                TaskManager::loadTask($todoContribute, $list_priority);
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
