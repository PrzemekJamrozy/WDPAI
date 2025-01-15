<?php

namespace Database;


use PDO;
use PDOException;
use Configs\DatabaseConfig;

class DatabaseProvider
{
    private static ?DatabaseProvider $instance = null;
    private string $host;
    private string $user;
    private string $password;
    private string $database;
    private int $port;

    public PDO $connection;

    private function __construct()
    {
        $this->host = DatabaseConfig::HOST;
        $this->user = DatabaseConfig::USER;
        $this->password = DatabaseConfig::PASSWORD;
        $this->database = DatabaseConfig::DATABASE;
        $this->port = DatabaseConfig::PORT;
        $this->connect();
    }


    public static function getInstance():DatabaseProvider{
        if(DatabaseProvider::$instance !== null){
            return DatabaseProvider::$instance;
        }
        DatabaseProvider::$instance = new static();
        return DatabaseProvider::$instance;
    }

    private function connect(): void
    {
        try {
            $connection = new PDO(
                "pgsql:host=$this->host;port=$this->port; dbname=$this->database",
                $this->user,
                $this->password,
                //required ssl mode
                ["sslmode"  => "prefer"]
            );

            //allows to display db errors
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $connection;
        }
        catch(PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
    }
}