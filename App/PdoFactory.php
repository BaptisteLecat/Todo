<?php 

namespace App;

//require('../conf.php');

define('PDO_DBNAME', 'todo');
define('PDO_HOST', 'localhost');
define('PDO_USER', 'todo');
define('PDO_PASSWORD', '');

class PdoFactory
{
    protected $pdo;

    public function __construct()
    {
        $dsn = 'mysql:dbname='.PDO_DBNAME.';host='.PDO_HOST;
        $this->pdo = new \PDO( $dsn, PDO_USER, PDO_PASSWORD);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    }

    public function pdo()
    {
        return $this->pdo;
    }

}


