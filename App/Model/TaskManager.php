<?php

/*
    Cette classe permet la gestion des requetes des Task.
*/

namespace App\Model;

//Permet de faire appel au class PdoFactory et Task présente dans des namespaces différents.
use App\PdoFactory;
use App\Model\Entity\Task;
use \PDOException;

class TaskManager extends PdoFactory
{
    // TODO InsertTask, UpdateTask(content_task enddate_task endtime_task status_task id_todo), Load

    public function loadTaskFromTodoObject($todoObject)
    {
        $response = ["success" => 0];
        try {
            $request = $this->pdo->prepare("SELECT id_task, content_task, enddate_task, endtime_task, active_task FROM task WHERE idtodo_task = :idtodo_task");
            if ($request->execute(array('idtodo_task' => $todoObject->getId()))) {
                if ($request->rowCount() > 0) {
                    while ($result = $request->fetch()) {
                        //A modifier si update de l'app en online Task.
                        $task = new Task(intval($result["id_task"]), $result["content_task"], $result["enddate_task"], $result["endtime_task"], $result["active_task"], $todoObject, $todoObject->getUserObject());
                    }
                    $response = ["success" => 1];
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $response;
    }

    public function loadTaskFromTaskId($idTask, $todoObject)
    {
        $response = ["success" => 0];
        try {
            $request = $this->pdo->prepare("SELECT content_task, enddate_task, endtime_task, active_task FROM task WHERE id_task = :id_task");
            if ($request->execute(array(':id_task' => $idTask))) {
                if ($request->rowCount() > 0) {
                    while ($result = $request->fetch()) {
                        //A modifier si update de l'app en online Task.
                        $task = new Task($idTask, $result["content_task"], $result["enddate_task"], $result["endtime_task"], $result["active_task"], $todoObject, $todoObject->getUserObject());
                    }
                    $response = ["success" => 1];
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $response;
    }

    private function countNbTask($idTodo)
    {
        $response = ["success" => 0];
        try {
            $request = $this->pdo->prepare("SELECT count(id_task) FROM task WHERE idtodo_task = :idtodo_task");
            if ($request->execute(array(':idtodo_task' => $idTodo))) {
                $result = $request->fetch();
                $response = ["success" => 1, "nbrow" => $result["count(id_task)"]];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $response;
    }

    public function insertTask($content, $endDate, $endTime, $todoObject)
    {
        $response = ["success" => 0];
        try {
            $resultCountTask = $this->countNbTask($todoObject->getId());
            if ($resultCountTask["success"] == 1) {
                $nbrow = $resultCountTask["nbrow"];
                $request = $this->pdo->prepare("INSERT INTO task (content_task, enddate_task, endtime_task, iduser_task, idtodo_task) VALUES (:content_task, :enddate_task, :endtime_task, :iduser_task, :idtodo_task)");
                if ($request->execute(array(':content_task' => $content, ':enddate_task' => $endDate, ':endtime_task' => $endTime, ':iduser_task' => $todoObject->getUserObject()->getId(), ':idtodo_task' => $todoObject->getId()))) {
                    $lastId = $this->pdo->lastInsertId();
                    $resultCountTask = $this->countNbTask($todoObject->getId());
                    if ($resultCountTask["success"] == 1) {
                        if ($nbrow < $resultCountTask["nbrow"]) {
                            $response = ["success" => 1, "idTask" => $lastId];
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $response;
    }
}
