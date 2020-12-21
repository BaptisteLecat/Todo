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
                if($endTime == ""){
                    $endTime = null; //Pour pouvoir spécifier lors de la création de l'objet.
                    $stringRequest = "INSERT INTO task (content_task, enddate_task, iduser_task, idtodo_task) VALUES (:content_task, :enddate_task, :iduser_task, :idtodo_task)";
                    $values = array(':content_task' => $content, ':enddate_task' => $endDate, ':iduser_task' => $todoObject->getUserObject()->getId(), ':idtodo_task' => $todoObject->getId());
                }else{
                    $stringRequest = "INSERT INTO task (content_task, enddate_task, endtime_task, iduser_task, idtodo_task) VALUES (:content_task, :enddate_task, :endtime_task, :iduser_task, :idtodo_task)";
                    $values = array(':content_task' => $content, ':enddate_task' => $endDate, ':endtime_task' => $endTime, ':iduser_task' => $todoObject->getUserObject()->getId(), ':idtodo_task' => $todoObject->getId());
                }
                $request = $this->pdo->prepare($stringRequest);
                if ($request->execute($values)) {
                    $lastId = $this->pdo->lastInsertId();
                    $resultCountTask = $this->countNbTask($todoObject->getId());
                    if ($resultCountTask["success"] == 1) {
                        if ($nbrow < $resultCountTask["nbrow"]) {
                            $response = ["success" => 1, "idTask" => $lastId];
                            $task = new Task($lastId, $content, $endDate, $endTime, 0, $todoObject, $todoObject->getUserObject());
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $response;
    }

    public function updateActive($taskObject, $value){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("UPDATE task SET active_task = :active_task WHERE id_task = :id_task");
            if($request->execute(array(':active_task' => $value, ':id_task' => $taskObject->getId()))){
                $taskObject->setActive($value);
                $response = ["success" => 1];
            }
        }catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $response;
    }

    public function updateTask($taskObject, $stringModif, $value){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("UPDATE task SET content_task = :content_task, enddate_task = :enddate_task, endtime_task = :endtime_task, idtodo_task = :idtodo_task WHERE id_task = :id_task");
            if($request->execute(array(':content_task' => $taskObject->getContent(), ':enddate_task' => $taskObject->getEndDate(), ':endtime_task' => $taskObject->getEndTime(), ':idtodo_task' => $taskObject->getTodoObject()->getId(), ':id_task' => $taskObject->getId()))){
                $response = ["success" => 1];
            }

        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $response;
    }

    public function deleteTask($taskObject){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("DELETE FROM task WHERE id_task = :id_task");
            if($request->execute(array(':id_task' => $taskObject->getId()))){
                $taskObject->getUserObject()->deleteTask($taskObject);
                $response = ["success" => 1];
            }
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $response;
    }
}
