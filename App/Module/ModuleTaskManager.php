<?php

namespace App\Module;

session_start();

use App\Model\PriorityManager;
use App\Model\TaskManager;
use Exception;

class ModuleTaskManager
{
    private static $userObject;

    public static function archiveTask($list_idTask, $idTodo)
    {
        $task_return = null;

        try {
            self::$userObject = unserialize($_SESSION["User"]);
            //Récupération de l'object associé à l'id todo passé en paramètre.
            $todoObject = self::getTodoObject($idTodo);

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

            return $task_return;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function achieveTask($idTask, $idTodo)
    {
        $task_return = null;

        try {
            $list_priority = PriorityManager::loadPriority();
            self::$userObject = unserialize($_SESSION["User"]);
            //Récupération de l'object associé à l'id todo passé en paramètre.
            $todoObject = self::getTodoObject($idTodo);

            //Comparaison avec chacune des task présente dans la todo.
            foreach ($todoObject->getList_Task() as $taskObject) {
                if ($idTask == $taskObject->getId()) {
                    //Archivage
                    TaskManager::achieveTask(self::$userObject, $taskObject);
                    TaskManager::reloadTask($taskObject, $list_priority);
                    $task_return = TaskManager::reloadTask($taskObject, $list_priority);
                    break;
                }
            }

            return $task_return;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    private static function getTodoObject($idTodo)
    {
        $todoObject = null;
        foreach (self::$userObject->getList_Todo() as $todo) {
            if ($todo->getId() == $idTodo) {
                $todoObject = $todo;
                break;
            }
        }
        return $todoObject;
    }
}
