<?php

namespace App\Model;

use Exception;
use App\PdoFactory;

/**
 * VisitorCounterManager
 * Static class to update and set the visitor counter stats.
 * 
 * @author Lecat Baptiste <baptiste.lecat44@gmail.com>
 * @version 1.0.0
 */
class VisitorCounterManager
{
    public static function insertVisitor($visitor_ip, $device)
    {
        try{
            $request = PdoFactory::getPdo()->prepare("INSERT INTO visitor (ip_visitor, device_visitor) VALUES (:ip_visitor, :device_visitor)");
            $request->execute(array(':ip_visitor' => $visitor_ip, "device_visitor" => $device));
        }catch(Exception $e){
            throw new Exception($e);
        }
    }
}
