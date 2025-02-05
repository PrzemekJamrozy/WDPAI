<?php

namespace Repositories;

use Models\Permission;
use Models\User;
use PDO;
use Permissions\Permissions;

class PermissionRepository extends BaseRepository
{
    public function provideTableName(): string
    {
        return 'permissions';
    }


    public function getUsersPermissions(int $userId): array
    {
        $sql = "SELECT 
    u.id AS user_id,
    u.name,
    u.surname,
    u.email,
    p.id AS permission_id,
    p.permission_name
    FROM 
        users u
    JOIN 
        user_has_permissions uhp ON u.id = uhp.user_id
    JOIN 
        permissions p ON uhp.permission_id = p.id
    WHERE 
        u.id = :user_id;";

        $stmt = $this->database->connection->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId
        ]);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($data)) {
            return [];
        }

        $perms = [];
        foreach ($data as $row) {
            $perms[] = Permission::fromData([
                'id' => $row['permission_id'],
                'permission_name' => $row['permission_name'],
            ]);
        }
        return $perms;
    }

    public function assignPermissionToUser(int $userId, int $permissionId): bool
    {
        $sql = "INSERT INTO user_has_permissions (user_id, permission_id) VALUES (:user_id, :permission_id);";
        $stmt = $this->database->connection->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':permission_id' => $permissionId
        ]);
    }


    /**
     * @param int $userId
     * @param array<int,int> $permissionsId
     * @return bool
     */
    public function assignPermissionsToUser(int $userId, array $permissionsId): bool
    {
        foreach ($permissionsId as $permissionId) {
            $this->assignPermissionToUser($userId, $permissionId);
        }
        return true;
    }

    /**
     * @param int $userId
     * @param array<int, int> $permissionsId
     * @return bool
     */
    public function syncPermissionsToUser(int $userId, array $permissionsId): bool
    {
        return $this->deleteUserPermissions($userId) &&
            $this->assignPermissionsToUser($userId, $permissionsId);
    }

    public function deleteUserPermissions(int $userId): bool
    {
        $sql = "DELETE FROM user_has_permissions WHERE user_id = :user_id;";
        $stmt = $this->database->connection->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId
        ]);
    }

    public function hasPermission(User $user, Permissions $permissionName): bool
    {
        $sql = "SELECT 
                u.id AS user_id,
                u.name,
                u.surname,
                u.email,
                p.id AS permission_id,
                p.permission_name
            FROM 
                users u
            JOIN 
                user_has_permissions uhp ON u.id = uhp.user_id
            JOIN 
                permissions p ON uhp.permission_id = p.id
            WHERE p.permission_name = :permissionName AND u.id = :userId;";

        $stmt = $this->database->connection->prepare($sql);
        $stmt->execute([
            ':permissionName' => $permissionName->value,
            ':userId' => $user->id
        ]);
        return count($stmt->fetchAll(PDO::FETCH_ASSOC)) > 0;
    }
}