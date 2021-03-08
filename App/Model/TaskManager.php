<?php

namespace App\Model;

use Exception;
use App\Model\Entity\Priority;
use App\Model\Entity\Task;
use App\Model\Entity\Todo;
use App\Model\Entity\User;
use App\PdoFactory;
use PDOException;

/**
 * TaskManager
 * Static class for CRUD Task requests.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class TaskManager
{
    /**
     * loadTask
     * Select task informations and create TaskObject.
     *
     * @param  mixed $todoObject
     * @param  mixed $list_priority
     * @return void
     */
    public static function loadTask(Todo $todoObject, $list_priority)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT id_task, title_task, content_task, achieved_task, enddate_task, id_priority FROM task WHERE id_todo = :id_todo and id_archived IS NULL");
            $request->execute(array(':id_todo' => $todoObject->getId()));
            while ($result = $request->fetch()) {
                foreach ($list_priority as $priority) {
                    if ($priority->getId() == $result["id_priority"]) {
                        $task = new Task($result["id_task"], $result["title_task"], $result["content_task"], $result["achieved_task"], $result["enddate_task"], $todoObject->getUserObject(), $todoObject, $priority);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * loadTaskFromId
     * Private function call after an insert to add the new Task.
     *
     * @param  mixed $idTask
     * @param  mixed $priorityObject
     * @param  mixed $todoObject
     * @param  mixed $userObject
     * @return void
     */
    private static function loadTaskFromId($idTask, Priority $priorityObject, Todo $todoObject, User $userObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT title_task, content_task, achieved_task, enddate_task FROM task WHERE id_task = :id_task");
            $request->execute(array(':id_task' => $idTask));
            $result = $request->fetch();
            $task = new Task($idTask, $result["title_task"], $result["content_task"], $result["achieved_task"], $result["enddate_task"], $userObject, $todoObject, $priorityObject);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * insertTask
     * Insert a new Task in database.
     *
     * @param  mixed $title
     * @param  mixed $content
     * @param  mixed $priorityObject
     * @param  mixed $todoObject
     * @param  mixed $userObject
     * @return void
     */
    public static function insertTask(string $title, string $content, $enddate, Priority $priorityObject, Todo $todoObject, User $userObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("call createTask (:p_idUser, :p_idTodo, :p_titleTask, :p_contentTask, :p_enddateTask, :p_idPriority)");
            $request->execute(array(':p_idUser' => $userObject->getId(), ':p_idTodo' => $todoObject->getId(), ':p_titleTask' => $title, ':p_contentTask' => $content, ':p_enddateTask' => $enddate, ':p_idPriority' => $priorityObject->getId()));
            self::loadTaskFromId(PdoFactory::getPdo()->lastInsertId(), $priorityObject, $todoObject, $userObject);
        } catch (PDOException $e) {
            echo ($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * updateTask
     * Update specified attribute of a task and check if user has the right to.
     *
     * @param  mixed $label
     * @param  mixed $value
     * @param  mixed $taskObject
     * @param  mixed $userObject
     * @return void
     */
    public static function updateTask(string $label, $value, Task $taskObject, User $userObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("call updateTask (:p_idUser, :p_idTask, :p_value, :p_updateLabel)");
            $request->execute(array(':p_idUser' => $userObject->getId(), ':p_idTask' => $taskObject->getId(), ':p_value' => $value, ':p_updateLabel' => $label));
            $taskObject->updateAttributeValue($label, $value);
        } catch (PDOException $e) {
            echo ($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * archiveTask
     * Archive task and check if user have the right to. Once a task is archived it can be removed only by the todo's owner.
     *
     * @param  mixed $userObject
     * @param  mixed $taskObject
     * @return void
     */
    public static function archiveTask(User $userObject, Task $taskObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("call archiveTask(:p_idUser, :p_idTask)");
            $request->execute(array(':p_idUser' => $userObject->getId(), ':p_idTask' => $taskObject->getId()));
            $result = $request->fetch();
            $request->closeCursor();
            if ($result["is_archived"] == true) {
                //Load taskarchive et ajout dans la tache.
                TaskArchivedManager::loadTaskArchiveFromTask($taskObject);
            } else {
                $taskObject->removeTaskArchivedObject();
            }
        } catch (PDOException $e) {
            echo ($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function deleteTask(User $userObject, Task $taskObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("call deleteTask(:p_idUser, :p_idTask)");
            $request->execute(array(':p_idUser' => $userObject->getId(), ':p_idTask' => $taskObject->getId()));
            $taskObject->delete();
        } catch (PDOException $e) {
            echo ($e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
