<?php

namespace App\Module;

session_start();

use App\Model\TaskManager;
use App\PdoFactory;
use Exception;

class ModuleTaskManager
{
    private static $userObject;

    public static function archiveTask($list_idTask, $idTodo)
    {
        try {
            PdoFactory::initConnection();
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
                        break;
                    }
                }
            }

            //Retourne la list avec les modifications effectué.
            return self::displayTask($todoObject);
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

    private static function displayTask($todo)
    {
        return count($todo->getList_TaskNoArchived());
    }
}
