<?php

namespace App\Model;

use Exception;
use App\Model\Entity\Task;
use App\Model\Entity\TaskAchieve;
use App\Model\Entity\TaskUpdated;
use App\Model\Entity\Todo;
use App\PdoFactory;

/**
 * TaskAchieveManager
 * Static class for load Task requests.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class TaskAchieveManager
{
    /**
     * loadTaskUpdatedFromTodo
     * Set taskArchiveObject of a task if it was archived.
     * Called for displaying the logs.
     *
     * @param  mixed $todoObject
     * @return void
     */
    public static function loadTaskAchieveFromTodo(Todo $todoObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT taskachieve_date.date_achieve, user.name_user, task.id_task
            FROM user, task_achieve, taskachieve_date, todo, task 
            WHERE user.id_user = task_achieve.id_user
            AND task_achieve.id_date = taskachieve_date.id_achieve
            AND task.id_task = task_achieve.id_task 
            AND task.id_todo = todo.id_todo 
            AND todo.id_todo = :id_todo 
            AND DAYOFYEAR(taskachieve_date.date_achieve) >= DAYOFYEAR(NOW()) - 10");
            $request->execute(array(':id_todo' => $todoObject->getId()));
            while ($result = $request->fetch()) {
                foreach ($todoObject->getList_Task() as $task) {
                    if ($task->getId() == $result["id_task"]) {
                        $taskAchieve = new TaskAchieve($result["date_achieve"], $result["name_user"], $task);
                        break;
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * loadTaskUpdatedFromTask
     * Called when a task was just updated.
     *
     * @param  mixed $taskObject
     * @return void
     */
    public static function loadTaskAchieveFromTask(Task $taskObject)
    {
        try {
            $request = PdoFactory::getPdo()->prepare("SELECT taskachieve_date.date_achieve, user.name_user 
            FROM task, task_achieve, taskachieve_date, user 
            WHERE task.id_task = task_achieve.id_task 
            AND taskachieve_date.id_achieve = task_achieve.id_date 
            AND user.id_user = task_achieve.id_user 
            AND task.id_task = :id_task");
            $request->execute(array(':id_task' => $taskObject->getId()));
            $result = $request->fetch();
            if ($request->rowCount() > 0) {
                $taskAchieve = new TaskAchieve($result["date_achieve"], $result["name_user"], $taskObject);
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
