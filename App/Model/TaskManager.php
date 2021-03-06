<?php

namespace App\Model;

use Exception;
use App\Model\Entity\Priority;
use App\Model\Entity\Task;
use App\Model\Entity\Todo;
use App\Model\Entity\User;
use App\Model\TaskAchieveManager;
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
            $request = PdoFactory::getPdo()->prepare("SELECT id_task, title_task, content_task, enddate_task, id_priority FROM task WHERE id_todo = :id_todo and id_archived IS NULL ORDER BY enddate_task ASC");
            $request->execute(array(':id_todo' => $todoObject->getId()));
            while ($result = $request->fetch()) {
                foreach ($list_priority as $priority) {
                    if ($priority->getId() == $result["id_priority"]) {
                        $task = new Task($result["id_task"], $result["title_task"], $result["content_task"], $result["enddate_task"], $todoObject->getUserObject(), $todoObject, $priority);
                        TaskAchieveManager::loadTaskAchieveFromTask($task);
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
            $request = PdoFactory::getPdo()->prepare("SELECT title_task, content_task, enddate_task FROM task WHERE id_task = :id_task ORDER BY enddate_task ASC");
            $request->execute(array(':id_task' => $idTask));
            $result = $request->fetch();
            $task = new Task($idTask, $result["title_task"], $result["content_task"], $result["enddate_task"], $userObject, $todoObject, $priorityObject);
            TaskAchieveManager::loadTaskAchieveFromTask($task);
            TaskArchivedManager::loadTaskArchivedFromTask($task);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public static function reloadTask(Task $taskObject, $list_priority)
    {
        $task = null;
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT title_task, content_task, enddate_task, id_priority FROM task WHERE id_task = :id_task and id_archived IS NULL");
            $request->execute(array(':id_task' => $taskObject->getId()));
            while ($result = $request->fetch()) {
                foreach ($list_priority as $priority) {
                    if ($priority->getId() == $result["id_priority"]) {
                        $task = new Task($taskObject->getId(), $result["title_task"], $result["content_task"], $result["enddate_task"], $taskObject->getUserObject(), $taskObject->getTodoObject(), $priority);
                        $taskObject->delete();
                        TaskAchieveManager::loadTaskAchieveFromTask($task);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }

        return $task;
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
            if($request->rowCount() > 0){
                $result = $request->fetch();
                $request->closeCursor();
                self::loadTaskFromId($result["_id_task"], $priorityObject, $todoObject, $userObject);
            }
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

    public static function achieveTask(User $userObject, Task $taskObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("call achieveTask(:p_idUser, :p_idTask)");
            $request->execute(array(':p_idUser' => $userObject->getId(), ':p_idTask' => $taskObject->getId()));
            $result = $request->fetch();
            $request->closeCursor();
            if ($result["is_achieve"] == true) {
                //Load taskachieve et ajout dans la tache.
                TaskAchieveManager::loadTaskAchieveFromTask($taskObject);
            } else {
                $taskObject->deleteTaskAchieveObject();
            }
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
                TaskArchivedManager::loadTaskArchivedFromTask($taskObject);
            } else {
                $taskObject->deleteTaskArchivedObject();
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
