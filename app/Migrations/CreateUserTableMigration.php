<?php

namespace Migrations;

use Database\DatabaseProvider;

class CreateUserTableMigration implements Migration
{

    private DatabaseProvider $database;

    public function __construct()
    {
        $this->database = DatabaseProvider::getInstance();
    }

    public function migrate(): void
    {
        $statement = "CREATE TABLE IF NOT EXISTS users (
                    id SERIAL PRIMARY KEY,
                    name VARCHAR(50) NOT NULL,
                    surname VARCHAR(50) NOT NULL,
                    email VARCHAR(100) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL
            );";

        $this->database->connection->exec($statement);
    }

}