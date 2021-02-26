<?php

namespace Model;

use Exception;
use Model\Entity\Task;
use Model\Entity\TaskArchived;
use Model\Entity\TaskUpdated;
use Model\Entity\Todo;
use NewFiles\PdoFactory;

/**
 * TaskUpdatedManager
 * Static class for load Task requests.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class TaskUpdatedManager
{    
    /**
     * loadTaskArchiveFromTodo
     * Set taskArchiveObject of a task if it was archived.
     * Called for displaying the logs.
     *
     * @param  mixed $todoObject
     * @return void
     */
    public static function loadTaskUpdatedFromTodo(Todo $todoObject){
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT taskupdate_date.date_update, user.name_user, task.id_task
            FROM user, task_update, taskupdate_date, todo, task 
            WHERE user.id_user = task_update.id_user
            AND task_update.id_date = taskupdate_date.id_update
            AND task.id_task = task_update.id_task 
            AND task.id_todo = todo.id_todo 
            AND todo.id_todo = :id_todo 
            AND DAYOFYEAR(taskupdate_date.date_update) >= DAYOFYEAR(NOW()) - 10");
             $request->execute(array(':id_todo' => $todoObject->getId()));
             while ($result = $request->fetch()) {
                $taskArchived = new TaskArchived($result["date_update"], $result["name_user"]);
                foreach ($todoObject->getList_Task() as $task) {
                    if($task->getId() == $result["id_task"]){
                        $task->setTaskArchivedObject($taskArchived);
                        break;
                    }
                }
             }
        }catch(Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * loadTaskUpdatedFromTask
     * Set taskUpdatedObject of a task if it was updated.
     * Called when a task was just updated.
     *
     * @param  mixed $taskObject
     * @return void
     */
    public static function loadTaskUpdatedFromTask(Task $taskObject){
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT taskupdate_date.date_update, user.name_user 
            FROM task, task_update, taskupdate_date, user 
            WHERE task.id_task = task_update.id_task 
            AND taskupdate_date.id_update = task_update.id_date 
            AND user.id_user = task_update.id_user 
            AND task.id_task = :id_task");
            $request->execute(array(':id_task' => $taskObject->getId()));
            $result = $request->fetch();
            if($request->rowCount() > 0){
                $taskUpdated = new TaskUpdated($result["date_update"], $result["name_user"]);
                $taskObject->setTaskUpdatedObject($taskArchived);
            }
        }catch(Exception $e){
            throw new Exception($e);
        }
    }
}
