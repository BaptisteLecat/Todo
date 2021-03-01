<?php

namespace App;

//require('../conf.php');

define('PDO_DBNAME', 'todov2');
define('PDO_HOST', 'localhost');
define('PDO_USER', 'root');
define('PDO_PASSWORD', '');

class PdoFactory
{
    private static $pdo;

    public static function initConnection()
    {
        $dsn = 'mysql:dbname=' . PDO_DBNAME . ';host=' . PDO_HOST;
        self::$pdo = new \PDO($dsn, PDO_USER, PDO_PASSWORD);
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    public static function getPdo()
    {
        return self::$pdo;
    }
}
