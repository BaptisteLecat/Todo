<?php

namespace App\Model;

use Exception;
use App\Model\Entity\Priority;
use App\PdoFactory;

/**
 * PriorityManager
 * Static class for load Priority.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class PriorityManager 
{
    /**
     * loadPriority
     * Select priority informations and create PriorityObject.
     * 
     * @return void
     */
    public static function loadPriority(){

        $list_priority = array();

        try{
            $request = PdoFactory::getPdo()->prepare("SELECT id_priority, label_priority FROM taskpriority");
            $request->execute();
            while ($result = $request->fetch()) {
                $priority = new Priority($result["id_priority"], $result["label_priority"]);
                array_push($list_priority, $priority);
            }
        }catch(Exception $e){
            throw new Exception($e);
        }

        return $list_priority;
    }
}
