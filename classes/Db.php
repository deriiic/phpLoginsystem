<?php


namespace App\Classes;

use mysqli;

class Db
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new mysqli($_HOST = 'localhost', $_USER = 'root', $_PASS = 'M3ilPh0n3t!?', $_DB = 'loginsystem');

        if ($this->connection->connect_error) {
            $this->error('Could not connect to MySQL - ' . $this->connection->connect_error);
        }
    }
}