<?php

namespace Migrations;

use Database\DatabaseProvider;

class CreateUserMatchesTableMigration implements Migration
{
    private DatabaseProvider $database;

    public function __construct()
    {
        $this->database = DatabaseProvider::getInstance();
    }

    public function migrate(): void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS user_matches (
            id SERIAL PRIMARY KEY,
            user_first_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            user_second_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
            first_want_match BOOLEAN NOT NULL,
            second_want_match BOOLEAN NOT NULL,
            show_match BOOLEAN GENERATED ALWAYS AS (first_want_match AND second_want_match) STORED,
            UNIQUE (user_first_id, user_second_id)
        );';

        $this->database->connection->exec($sql);
    }


}