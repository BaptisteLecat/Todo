<?php 

/*
    Cette classe permet la gestion des requetes des Task.
*/

namespace App\Model;

//Permet de faire appel au class PdoFactory et Todo présente dans des namespaces différents.
use App\PdoFactory;
use App\Model\Entity\Todo;

class TodoManager extends PdoFactory
{ 
    //Update une todo -> Modif title, active
    //


    //Permet de charger tout les TODO d'un USER.
    //Renvoie un tableau d'object TODO: NULL si 0 TODO pour le USER.
    public function loadTodoFromIdUser($idUser){
        $response = ["success" => 0];
        $i = 0;
        $list_todo = array();

        try{
            $request = $this->pdo->prepare("SELECT id_todo, title_todo, active_todo, status_todo, createdate_todo FROM todo WHERE iduser_todo = :iduser_todo and active_todo = 1");
            if($request->execute(array(':iduser_todo' => $idUser))){
                if($request->rowCount() > 0){
                    while ($result = $request->fetch()) {
                        $todo = new Todo($result["id_todo"], $result["title_todo"], $result["active_todo"], $result["status_todo"], $result["createdate_todo"]);
                        $list_todo[$i] = $todo;
                        $i++;
                    }
                }
                $response = ["success" => 1, "list_todo" => $list_todo];
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }

    //Permet de modifier les informations concernant un TODO: "Active" ou "Title".
    //Necessite IdTodo, stringModif => string identifiant l'informations que l'on souhaite modifier, $value => nouvelle valeur.
    public function updateTodoFromIdTodo($idTodo, $stringModif, $value){
        $response = ["success" => 0];

        try{
            switch ($stringModif) {
                case 'title':
                    $request = $this->pdo->prepare("UPDATE todo SET title_todo = :title_todo WHERE id_todo = :id_todo");
                    $parameters = array(":title_todo" => $value, ":id_todo" => $idTodo);
                    break;

                case 'active':
                    $request = $this->pdo->prepare("UPDATE todo SET active_todo = :active_todo WHERE id_todo = :id_todo");
                    $parameters = array(":active_todo" => $value, ":id_todo" => $idTodo);
                    break;
                
                default:
                    break;
            }

            if(isset($request)){
                if($request->execute($parameters)){
                    $response = ["success" => 1];
                }
            }
            
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }

    private function countTodoRow(){
        $response = ["success" => 0];

        try{
            $request = $this->pdo->prepare("SELECT 'count'(id_todo) FROM todo");
            if($request->execute()){
                $result = $request->fetch();
                $response = ["success" => 1, "nbrow" => $result["count(id_todo)"]];
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }

        return $response;
    }


    public function insertTodo($title, $active, $status, $idUser){
        $response = ["success" => 0];
        //Nombre de Row dans la table TODO avant insertion.
        $resultCount = countTodoRow();

        if($resultCount["success"] == 1){
            $nbrow = $resultCount["nbrow"];
            try{
                $request = $this->pdo->prepare("INSERT INTO todo (title_todo, active_todo, status_todo, iduser_todo) VALUES (:title_todo, :active_todo, :status_todo, :iduser_todo)");
                if($request->execute(array(':title_todo' => $title, ':active_todo' => $active, ':status_todo' => $status, ':iduser_todo' => $idUser))){
                    //Nombre de Row dans la table TODO après insertion.
                    $resultCount = countTodoRow();
                    if($resultCount["success"] == 1){
                        if($nbrow < $resultCount["nbrow"]){
                            $response = ["success" => 1, "insertTodoId" => $this->pdo->lastInsertId()];
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
