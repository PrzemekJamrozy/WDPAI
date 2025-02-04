<?php

namespace Repositories;

use Enums\UserSex;
use Models\User;
use PDO;

class UserRepository extends BaseRepository
{
    public function provideTableName(): string
    {
        return 'users';
    }

    public function createUser(string $name, string $surname, string $email, string $password, string $sex): bool
    {
        $stmt = $this->database->connection->prepare("INSERT INTO users (name,surname, email, password, sex, had_onboarding, avatar_url) VALUES (:name, :surname ,:email, :password, :sex, false, '')");
        return $stmt->execute([
            ":name" => $name,
            ":surname" => $surname,
            ":email" => $email,
            ":password" => $password,
            ":sex" => $sex
        ]);
    }

    public function updateUser(int $userId, string $name, string $surname, string $email, string $password, UserSex $sex): bool
    {
        $sql = "UPDATE users SET 
                name = :name,
                surname = :surname,
                email = :email,
                password = :password,
                sex = :sex WHERE id = :userId;";
        return $this->database->connection->prepare($sql)->execute([
            ":userId" => $userId,
            ':name' => $name,
            ':surname' => $surname,
            ':email' => $email,
            ':password' => $password,
            ':sex' => $sex->value
        ]);
    }

    public function setUserAvatar(int $userId, string $avatar_url): bool
    {
        $sql = "UPDATE users SET avatar_url = :avatar WHERE id = :userId;";
        return $this->database->connection->prepare($sql)->execute([
            ":userId" => $userId,
            ":avatar" => $avatar_url
        ]);
    }

    public function setUserOnboardingStatus(int $userId, bool $isOnboardingDone): bool
    {
        $sql = "UPDATE users SET had_onboarding = :isOnboardingDone WHERE id = :userId;";
        return $this->database->connection->prepare($sql)->execute([
            ":userId" => $userId,
            ":isOnboardingDone" => $isOnboardingDone
        ]);
    }

    public function getUserByEmail(string $email): User|false
    {
        $stmt = $this->database->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([
            ":email" => $email
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return false;
        }
        return User::fromData($data);
    }

    public function getUserById(int $userId): User|false
    {
        $stmt = $this->database->connection->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->execute([
            ":userId" => $userId
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return false;
        }
        return User::fromData($data);
    }

    /**
     * @param UserSex $userSex
     * @return array<int,User>
     */
    public function getUsersBySex(UserSex $userSex): array
    {
        $sql = 'SELECT * FROM users WHERE sex = :userSex';
        $stmt = $this->database->connection->prepare($sql);
        $stmt->execute([
            ':userSex' => $userSex->value
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($data as $user) {
            $users[] = User::fromData($user);
        }
        return $users;
    }


    public function deleteUser(int $userId): bool
    {
        $sql = "DELETE FROM users WHERE id = :userId;";
        return $this->database->connection->prepare($sql)->execute([
            ":userId" => $userId
        ]);
    }
}