<?php

namespace App\Module\Settings;

session_start();

use Exception;
use App\Loader;

use App\Model\Entity\Todo;
use App\Model\TodoManager;
use App\Model\ContributeManager;
use App\Model\Exceptions\InputException;
use App\Model\Exceptions\PermissionException;
use App\Model\TodoTokenManager;

/**
 * ModuleTaskManager
 * Cette classe permet de gerer les fonctionnalitées liés au tâches, dans une todo.
 */
class ModuleInvitations
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

    public static function generateToken(int $idTodo)
    {
        $list_token = array();
        $isGenerated = false; //Il est possible que l'on ne trouve pas la permission 1 et que donc on n'execute pas la requete.

        self::loading();
        //Récupération de l'object associé à l'id todo passé en paramètre.
        $todoObject = self::getTodoObject($idTodo);

        if ($todoObject != null && $todoObject->getOwned()) {
            foreach (self::$appObject->getList_Permission() as $permission) {
                if ($permission->getId() == 1) { //La permission par défaut qui doit être utilisé par la token.
                    TodoTokenManager::createToken($permission, $todoObject);
                    $isGenerated = true;
                    break;
                }
            }

            if (!$isGenerated) { //Il est possible que l'on ne trouve pas la permission 1 et que donc on n'execute pas la requete.
                throw new Exception("Le token n'a pas pu être généré.");
            }
            $list_token = $todoObject->getList_TodoToken();
        } else {
            throw new PermissionException(5);
        }

        return $list_token;
    }

    public static function deleteToken(string $token)
    {
        $list_token = array();

        self::loading();
        //Récupération de l'object associé au token passé en paramètre.
        $tokenObject = self::getTokenObject($token);

        if ($tokenObject != null && $tokenObject->getTodoObject()->getOwned()) {
            TodoTokenManager::deleteToken($tokenObject);
            $list_token = array_values($tokenObject->getTodoObject()->getList_TodoToken());
        } else {
            throw new PermissionException(5);
        }

        return $list_token;
    }

    public static function regenerateToken(string $token)
    {
        $list_token = array();

        self::loading();
        //Récupération de l'object associé au token passé en paramètre.
        $tokenObject = self::getTokenObject($token);

        if ($tokenObject != null && $tokenObject->getTodoObject()->getOwned()) {
            TodoTokenManager::regenerateToken($tokenObject);
            $list_token = array_values($tokenObject->getTodoObject()->getList_TodoToken());
        } else {
            throw new PermissionException(5);
        }

        return $list_token;
    }

    public static function refuseContributor(int $idContributor, int $idTodo)
    {
        $list_participant = array();

        self::loading();
        //Récupération de l'object associé à l'id todo passé en paramètre.
        $todoObject = self::getTodoObject($idTodo);

        if ($todoObject != null && $todoObject->getOwned()) {
            //Récupération de l'object associé à l'id du contributeur.
            $contributorObject = self::getContributorObject($idContributor, $todoObject);

            ContributeManager::refuseContributor($contributorObject, $todoObject);
            $list_participant = ContributeManager::loadUsersOfTodo($todoObject, self::$appObject->getList_Permission());
        } else {
            throw new PermissionException(5);
        }

        return $list_participant;
    }

    public static function acceptContributor(int $idContributor, int $idTodo)
    {
        $list_participant = array();

        self::loading();
        //Récupération de l'object associé à l'id todo passé en paramètre.
        $todoObject = self::getTodoObject($idTodo);

        if ($todoObject != null && $todoObject->getOwned()) {
            //Récupération de l'object associé à l'id du contributeur.
            $contributorObject = self::getContributorObject($idContributor, $todoObject);
            ContributeManager::acceptContributor($contributorObject, $todoObject);

            $list_participant = ContributeManager::loadUsersOfTodo($todoObject, self::$appObject->getList_Permission());
        } else {
            throw new PermissionException(5);
        }

        return $list_participant;
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

    private static function getTokenObject(string $token)
    {
        $tokenObject = null;
        $isFinded = false;


        foreach (self::$user->getList_Todo() as $todo) {
            //Il faut load tout les tokens associés aux todo du user.
            TodoTokenManager::loadTokenFromTodo($todo);
            foreach ($todo->getList_TodoToken() as $todoToken) {
                if ($todoToken->getToken() == $token) {
                    $tokenObject = $todoToken;
                    $isFinded = true;
                    break;
                }
            }

            if ($isFinded) {
                break;
            }
        }

        return $tokenObject;
    }
}
