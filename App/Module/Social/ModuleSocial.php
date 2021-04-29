<?php

namespace App\Module\Social;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Exception;

use App\Loader;
use App\Model\PendingContributeManager;
use App\Model\TodoManager;
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

    public static function submitToken(string $token)
    {
        self::loading();
        TodoTokenManager::submitToken($token, self::$user);

        return self::loadPendingContribute();
    }

    public static function cancelContributeRequest(int $idTodo)
    {
        self::loading();

        PendingContributeManager::cancelPendingContribute(self::$user, $idTodo);

        return self::loadPendingContribute();
    }

    private static function loadPendingContribute()
    {
        return PendingContributeManager::loadPendingContribute(self::$user);
    }
}
