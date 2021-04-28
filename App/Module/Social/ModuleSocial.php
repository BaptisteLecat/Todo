<?php

namespace App\Module\Social;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Exception;

use App\Loader;
use PDOException;
use App\Model\TodoTokenManager;

/**
 * ModuleHome
 * Cette classe permet de gerer les fonctionnalitées liés au tâches, dans une todo.
 */
class ModuleSocial
{
    private static $user;
    private static $appObject;

    public static function getUserObject()
    {
        if (is_null(self::$user)) {
            self::loading();
        }
        return self::$user;
    }

    private static function loading()
    {
        self::$appObject = unserialize($_SESSION["App"]);

        self::$user = unserialize($_SESSION["User"]);
        Loader::LoadUser(self::$user, self::$appObject->getList_TodoIcon(), self::$appObject->getList_Priority());
        Loader::loadContribute(self::$user, self::$appObject->getList_TodoIcon(), self::$appObject->getList_Permission(), self::$appObject->getList_Priority());
    }

    public static function submitToken($token)
    {
        self::loading();
        TodoTokenManager::submitToken($token, self::$user);
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
