<?php

namespace App\Module\Settings;

session_start();

use Exception;
use App\Loader;

use App\Model\ContributeManager;
use App\Model\Exceptions\PermissionException;
use App\Model\TodoManager;

/**
 * ModuleTaskManager
 * Cette classe permet de gerer les fonctionnalitées liés au tâches, dans une todo.
 */
class ModuleInformations
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

    public static function updateTodoInfo(int $idTodo, $elements)
    {
        self::loading();
        //Récupération de l'object associé à l'id todo passé en paramètre.
        $todoObject = self::getTodoObject($idTodo);

        if ($todoObject != null && $todoObject->getOwned()) {
            //Parcours des éléments du formulaire.
            foreach (array_keys($elements) as $attribute) {
                //Update de chacun des éléments.
                $todoObject = TodoManager::updateTodo($attribute, $elements[$attribute], $todoObject);
            }
        } else {
            throw new PermissionException(5);
        }

        return $todoObject;
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
}
