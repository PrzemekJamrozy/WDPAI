<?php

namespace Migrations;
require_once 'autoloader.php';

class Migrator implements Migration
{

    /**
     * @var Migration[]
     */
    private array $migrationsToRun;

    public function __construct()
    {
        $this->migrationsToRun = [
            new CreateUserTableMigration(), // DONE
            new CreatePermissionsTableMigration(), //DONE
            new CreateUserToPermissionTableMigration(), // DONE
            new CreateUserProfileTableMigration(),
            new CreateUserMatchesTableMigration()
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
