<?php

namespace Migrations;

use Database\DatabaseProvider;

class CreatePermissionsTableMigration implements Migration
{


    private DatabaseProvider $database;

    public function __construct()
    {
        $this->database = DatabaseProvider::getInstance();
    }

    public function migrate(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS permissions (
                 id SERIAL PRIMARY KEY,
                 permission_name VARCHAR(255)
    );";
        $this->database->connection->exec($sql);
    }


}