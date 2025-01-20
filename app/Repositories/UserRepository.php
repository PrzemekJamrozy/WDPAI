<?php

namespace Repositories;

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
        $stmt = $this->database->connection->prepare("INSERT INTO users (name,surname, email, password, sex) VALUES (:name, :surname ,:email, :password, :sex)");
        return $stmt->execute([
            ":name" => $name,
            ":surname" => $surname,
            ":email" => $email,
            ":password" => $password,
            ":sex" => $sex
        ]);
    }

    public function updateUser(int $userId, string $name, string $surname, string $email, string $password, string $sex): bool
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
            ':sex' => $sex
        ]);
    }

    public function getUserByEmail(string $email): User|false
    {
        $stmt = $this->database->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$data){
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
        if(!$data){
            return false;
        }
        return User::fromData($data);
    }


    public function deleteUser(int $userId): bool
    {
        $sql = "DELETE FROM users WHERE id = :userId;";
        return $this->database->connection->prepare($sql)->execute([
            ":userId" => $userId
        ]);
    }
}