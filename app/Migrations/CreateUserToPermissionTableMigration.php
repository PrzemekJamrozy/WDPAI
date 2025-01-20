<?php

namespace Migrations;

use Database\DatabaseProvider;

class CreateUserToPermissionTableMigration implements Migration
{
    private DatabaseProvider $database;

    public function __construct()
    {
        $this->database = DatabaseProvider::getInstance();
    }

    public function migrate(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS user_has_permissions (
            id SERIAL PRIMARY KEY,
            user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            permission_id INT NOT NULL REFERENCES permissions(id) ON DELETE CASCADE,
            UNIQUE (user_id, permission_id)
    );";
        $this->database->connection->exec($sql);
    }


}