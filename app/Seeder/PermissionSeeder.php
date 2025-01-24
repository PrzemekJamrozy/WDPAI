<?php

namespace Seeder;

use Permissions\Permissions;

class PermissionSeeder extends BaseSeeder
{
    public function seed():void
    {
        $permissions = Permissions::cases();
        $sql = "INSERT INTO permissions (permission_name) VALUES ";
        foreach ($permissions as $permission) {
            $sql .= "('" . $permission->value . "'),";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ';';
        $this->database->connection->exec($sql);
    }

}