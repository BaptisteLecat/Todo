<?php 

namespace App;

class PdoFactory
{
    protected $pdo;

    public function __construct()
    {
        $dsn = 'mysql:dbname=todo_database;host=mysql-todo.alwaysdata.net';
        //Local
        //$dsn = 'mysql:dbname=todo;host=127.0.0.1';
        $user = 'todo';
        //Local
        //$user = 'root';
        $password = 'baptiste24590';
        //Local
        //$password = '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    public function pdo()
    {
        return $this->pdo;
    }

}


