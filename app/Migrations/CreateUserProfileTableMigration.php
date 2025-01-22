<?php

namespace Migrations;

use Database\DatabaseProvider;

class CreateUserProfileTableMigration implements Migration
{

    private DatabaseProvider $database;

    public function __construct()
    {
        $this->database = DatabaseProvider::getInstance();
    }

    public function migrate(): void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS users_profiles (
            id SERIAL PRIMARY KEY,
            user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            preferred_sex VARCHAR(10) NOT NULL,
            user_bio TEXT NOT NULL,
            facebook_link VARCHAR(255) NOT NULL,
            instagram_link VARCHAR(255) NOT NULL
        );';

        $this->database->connection->exec($sql);
    }


}