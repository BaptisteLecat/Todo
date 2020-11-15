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
    public function loadTodoFromIdUser($idUser){
        $response = ["success" => 0];
        $i = 0;
        $list_todo = array();

        try{
            $request->pdo->prepare("SELECT id_todo, title_todo, active_todo, status_todo, createdate_todo FROM todo WHERE iduser_todo = :iduser_todo and active_todo = 1");
            if($request->execute(array(':id_user' => $idUser))){
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
}
