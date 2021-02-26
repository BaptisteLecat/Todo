<?php

namespace Model;

use Exception;
use NewFiles\PdoFactory;
use Model\Entity\Permission;

/**
 * PermissionManager
 * Static class for loading Permissions.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class PermissionManager  
{    
    /**
     * loadPermission
     * Load all the permissions can be used for a Todo.
     *
     * @return void
     */
    public static function loadPermission(){
        $list_permission = array();
        try{
            $request = PdoFactory::getPdo()->prepare("SELECT id_permission, label_permission FROM permission");
            $request->execute();
            while ($result = $request->fetch()) {
                $permission = new Permission($result["id_permission"], $result["label_permission"]);
                array_push($list_permission, $permission);
            }
        }catch(Exception $e){
            throw new Exception($e);
        }
        return $list_permission;
    }
}
