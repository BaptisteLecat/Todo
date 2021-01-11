<?php

namespace App\Model;

use App\Model\Entity\Todo_icon;
use App\PdoFactory;
use PDOException;

class TodoIconManager extends PdoFactory
{
    public function loadTodoIcon()
    {
        $response = ["success" => 0];
        $list_todoIcons = array();

        try {
            $request = $this->pdo->prepare("SELECT * FROM todo_icon");
            if ($request->execute()) {
                while ($result = $request->fetch()) {
                    $todo_icon = new Todo_icon($result["id_icon"], $result["name_icon"]);
                    array_push($list_todoIcons, $todo_icon);
                }
                $response["success"] = 1;
                $response["list_todoIcons"] = $list_todoIcons;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $response;
    }
}
