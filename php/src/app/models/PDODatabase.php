<?php

namespace MyApp\Models;

use MyApp\Models\DatabaseInterface;
use \PDO;
use \PDOException;

class PDODatabase implements DatabaseInterface
{
    private $host = 'mysql-service';
    private $username = 'MYSQL_USER';
    private $password = 'MYSQL_PASSWORD';
    private $databaseName = 'MYSQL_DATABASE';
    private $connection;

    public function connect()
    {
        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->databaseName, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->connection;
    }
}
