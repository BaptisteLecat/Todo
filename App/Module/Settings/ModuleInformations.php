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
        //Verification des champs.
        self::checkElementsInput($elements);
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

    public static function updateUserRight(int $idTodo, int $idContributor, $right)
    {
        $contributorObject = null;
        self::loading();
        //Récupération de l'object associé à l'id todo passé en paramètre.
        $todoObject = self::getTodoObject($idTodo);
        //Récupération de l'object associé à l'id du contributeur.
        $contributorObject = self::getContributorObject($idContributor, $todoObject);

        if ($todoObject != null && $todoObject->getOwned()) {
            if ($contributorObject != null) {
                $permissionObject = null;
                foreach ($contributorObject->getList_Permission() as $permission) {
                    if ($permission->getId() == $right) {
                        $permissionObject = $permission;
                        break;
                    }
                }

                if ($permissionObject == null) {
                    //Ajout de la permission.
                    $permissionObject = self::getPermissionObject($right);
                    if ($permissionObject != null) {
                        ContributeManager::insertContribute($contributorObject, $todoObject, $permissionObject);
                    }
                } else {
                    //Suppression de la permission
                    ContributeManager::deleteContribute($contributorObject, $todoObject, $permissionObject);
                }
            } else {
                //TODO user doesn't exist.
            }
        } else {
            throw new PermissionException(5);
        }

        return $contributorObject;
    }

    private static function checkElementsInput($elements)
    {
        foreach (array_keys($elements) as $attribute) {
            switch ($attribute) {
                case 'title':
                    if (strlen($elements[$attribute]) > 10) {
                        throw new InputException(1, null, 10);
                    }
                    break;

                case 'description':
                    if (strlen($elements[$attribute]) > 200) {
                        throw new InputException(1, null, 200);
                    }
                    break;

                default:
                    break;
            }
        }
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
