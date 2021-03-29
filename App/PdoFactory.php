<?php

namespace App;

//require('../conf.php');

define('PDO_DBNAME', 'todo_database');
define('PDO_HOST', 'mysql-todo.alwaysdata.net');
define('PDO_USER', 'todo');
define('PDO_PASSWORD', 'baptiste24590');

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
        if (is_null(self::$pdo)) {
            self::initConnection();
        }

        return self::$pdo;
    }
}
