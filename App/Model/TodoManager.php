<?php 

/*
    Cette classe permet la gestion des requetes des Task.
*/

namespace App\Model;

//Permet de faire appel au class PdoFactory et Todo présente dans des namespaces différents.
use App\PdoFactory;
use App\Model\Entity\Todo;
use \PDOException;

class TodoManager extends PdoFactory
{ 

    /**
     * Permet de charger tout les TODO d'un USER.
     * @param User $userObject Afin de récupérer l'id du User.
     * @return int|Todo[success,listTodo] Success 0 = listTodo none | Success = 1 listTodo ou listTodo = null.
     */
    public function loadTodoFromUserObject($userObject){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT id_todo, title_todo, active_todo, status_todo, createdate_todo FROM todo WHERE iduser_todo = :iduser_todo and active_todo = 1");
            if($request->execute(array(':iduser_todo' => $userObject->getId()))){
                if($request->rowCount() > 0){
                    while ($result = $request->fetch()) {
                        $todo = new Todo(intval($result["id_todo"]), $result["title_todo"], intval($result["active_todo"]), $result["status_todo"], $result["createdate_todo"], $userObject);
                    }
                }
                $response = ["success" => 1];
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }

    /**
     * Permet de modifier les informations concernant un TODO: "Active" ou "Title".
     * @param Todo $idTodo
     * @param string $stringModif Correspond à l'attribut que l'on souhaite modifier.
     * @param string|int $value Nouvelle valeur de la propriété.
     * @return int[] $response 0 -> Echec 1 -> Réussie.
     */ 
    public function updateTodoFromTodoObject($todoObject, $stringModif, $value){
        $response = ["success" => 0];

        try{
            switch ($stringModif) {
                case 'title':
                    $request = $this->pdo->prepare("UPDATE todo SET title_todo = :title_todo WHERE id_todo = :id_todo");
                    $parameters = array(":title_todo" => $value, ":id_todo" => $todoObject->getId());
                    if($request->execute($parameters)){
                        $todoObject->setTitle($value);
                        $response = ["success" => 1];
                    }
                    break;

                case 'active':
                    $request = $this->pdo->prepare("UPDATE todo SET active_todo = :active_todo WHERE id_todo = :id_todo");
                    $parameters = array(":active_todo" => $value, ":id_todo" => $todoObject->getId());
                    if($request->execute($parameters)){
                        $todoObject->setActive($value);
                        $response = ["success" => 1];
                    }
                    break;
                
                default:
                    break;
            }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }

    private function countTodoRow($idUser){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT count(id_todo) FROM todo WHERE idtodo_user = :idtodo_user");
            if($request->execute(array(':idtodo_user' => $idUser))){
                $result = $request->fetch();
                $response = ["success" => 1, "nbrow" => $result["count(id_todo)"]];
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }


    public function insertTodo($title, $status, $userObject){
        $response = ["success" => 0];
        //Nombre de Row dans la table TODO avant insertion.
        $resultCount = $this->countTodoRow($userObject->getId());

        if($resultCount["success"] == 1){
            $nbrow = $resultCount["nbrow"];
            try{
                $request = $this->pdo->prepare("INSERT INTO todo (title_todo, status_todo, iduser_todo) VALUES (:title_todo, :status_todo, :iduser_todo)");
                if($request->execute(array(':title_todo' => $title, ':status_todo' => $status, ':iduser_todo' => $userObject->getId()))){
                    //Nombre de Row dans la table TODO après insertion.
                    $resultCount = $this->countTodoRow($userObject->getId());
                    if($resultCount["success"] == 1){
                        if($nbrow < $resultCount["nbrow"]){
                            $response = ["success" => 1];
                        }
                    }
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        return $response;
    }
}
