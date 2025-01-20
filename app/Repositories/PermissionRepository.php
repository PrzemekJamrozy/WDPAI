<?php

namespace Repositories;

use Models\User;
use PDO;

class PermissionRepository extends BaseRepository
{
    public function provideTableName(): string
    {
        return 'permissions';
    }


    public function getUsersPermissions(int $userId): array|false
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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        return $this->asTransaction(function () use ($userId, $permissionsId) {
            $this->deleteUserPermissions($userId);
            $this->assignPermissionsToUser($userId, $permissionsId);
        });
    }

    public function deleteUserPermissions(int $userId): bool
    {
        $sql = "DELETE FROM user_has_permissions WHERE user_id = :user_id;";
        $stmt = $this->database->connection->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId
        ]);
    }

    public function hasPermission(User $user, string $permissionName): bool
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
            ':permissionName' => $permissionName,
            ':userId' => $user->id
        ]);
        return count($stmt->fetchAll(PDO::FETCH_ASSOC)) > 0;
    }
}