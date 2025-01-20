<?php

namespace Migrations;
require_once 'autoloader.php';

class Migrator implements Migration
{

    /**
     * @var CreateUserTableMigration[]
     */
    private array $migrationsToRun;

    public function __construct()
    {
        /** @var CreateUserTableMigration[] $migrationsToRun */
        $this->migrationsToRun = [
            new CreateUserTableMigration(), // DONE
            new CreatePermissionsTableMigration(), //DONE
            new CreateUserToPermissionTableMigration() // DONE
        ];
    }

    public function migrate(): void
    {
        foreach ($this->migrationsToRun as $migration) {
            $migration->migrate();
        }
    }
}

(new Migrator())->migrate();
