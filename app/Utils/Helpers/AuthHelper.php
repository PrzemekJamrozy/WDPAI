<?php

namespace Utils\Helpers;

session_start();

use Models\User;
use Repositories\UserRepository;
use Responses\ErrorResponse;

class AuthHelper
{
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * @param User $user
     * @return array Session array
     */
    public static function createUserSession(User $user): array
    {
        $_SESSION['user_id'] = $user->id;
        return $_SESSION;
    }

    public static function getUserFromSessionSession(): User
    {
        if (!isset($_SESSION['user_id'])) {
            die(
            (new ErrorResponse(['message' => 'Not logged in']))
                ->toJson()
            );
        }
        return UserRepository::provideRepository()
            ->getUserById($_SESSION['user_id']);
    }

    public static function destroyUserSession(): void
    {
        session_destroy();
    }

}