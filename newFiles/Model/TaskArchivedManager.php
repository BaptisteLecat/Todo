<?php

namespace Model;

use Exception;
use Model\Entity\Task;
use Model\Entity\TaskArchived;
use Model\Entity\Todo;
use NewFiles\PdoFactory;

/**
 * TaskArchivedManager
 * Static class for load Task requests.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class TaskArchivedManager
{    
    /**
     * loadTaskArchiveFromTodo
     * Set taskArchiveObject of a task if it was archived.
     * Called for displaying the logs.
     *
     * @param  mixed $todoObject
     * @return void
     */
    public static function loadTaskArchiveFromTodo(Todo $todoObject){
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT taskarchive_date.date_archive, user.name_user, task.id_task
            FROM user, task_archive, taskarchive_date, todo, task 
            WHERE user.id_user = task_archive.id_user
            AND task_archive.id_date = taskarchive_date.id_archive
            AND task.id_task = task_archive.id_task 
            AND task.id_todo = todo.id_todo 
            AND todo.id_todo = :id_todo 
            AND DAYOFYEAR(taskarchive_date.date_archive) >= DAYOFYEAR(NOW()) - 10");
             $request->execute(array(':id_todo' => $todoObject->getId()));
             while ($result = $request->fetch()) {
                $taskArchived = new TaskArchived($result["date_archive"], $result["name_user"]);
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
     * loadTaskArchiveFromTask
     * Set taskArchiveObject of a task if it was archived.
     * Called when a task was just archived.
     *
     * @param  mixed $taskObject
     * @return void
     */
    public static function loadTaskArchiveFromTask(Task $taskObject){
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT taskarchive_date.date_archive, user.name_user 
            FROM task, task_archive, taskarchive_date, user 
            WHERE task.id_task = task_archive.id_task 
            AND taskarchive_date.id_archive = task_archive.id_date 
            AND user.id_user = task_archive.id_user 
            AND task.id_task = :id_task");
            $request->execute(array(':id_task' => $taskObject->getId()));
            $result = $request->fetch();
            if($request->rowCount() > 0){
                $taskArchived = new TaskArchived($result["date_archive"], $result["name_user"]);
                $taskObject->setTaskArchivedObject($taskArchived);
            }
        }catch(Exception $e){
            throw new Exception($e);
        }
    }
}
