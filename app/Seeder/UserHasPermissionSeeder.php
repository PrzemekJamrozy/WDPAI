<?php

namespace Seeder;

use Permissions\Permissions;

class UserHasPermissionSeeder extends BaseSeeder
{
    public function seed(): void
    {
        $userIds = range(1, 9);
        $sql = 'INSERT INTO user_has_permissions (user_id, permission_id) VALUES';

        $permUser = Permissions::PERMISSION_USER;
        foreach ($userIds as $userId) {
            $sql .= ' (' . $userId . ',2),';
        }
        $sql .= '(10,1)';

        $this->database->connection->exec($sql);
    }


}