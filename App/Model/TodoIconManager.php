<?php

namespace App\Model;

use App\Model\Entity\TodoIcon;
use App\PdoFactory;
use Exception;

/**
 * TodoIconManager
 * Static class for CRUD TodoIcon requests.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class TodoIconManager
{
    /**
     * loadTodoIcon
     * Select TodoIcon informations and create TodoIconObject.
     *
     * @return array $list_todoIcon
     */
    public static function loadTodoIcon(){

        $list_todoIcon = array();

        try{
            $request = PdoFactory::getPdo()->prepare("SELECT id_icon, label_icon FROM todo_icon");
            $request->execute();
            while ($result = $request->fetch()) {
                $todoIcon = new TodoIcon($result["id_icon"], $result["label_icon"]);
                array_push($list_todoIcon, $todoIcon);
            }
        }catch (Exception $e) {
            throw new Exception($e);
        }

        return $list_todoIcon;
    }
}
