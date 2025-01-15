<?php

namespace Queries;

use Models\User;
use PDO;

class UserRepository extends BaseRepository
{
    public function provideTableName(): string
    {
        return 'users';
    }

    public function createUser(string $name, string $surname, string $email, string $password): bool
    {
        $stmt = $this->database->connection->prepare("INSERT INTO users (name,surname, email, password) VALUES (:name, :surname ,:email, :password)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":surname", $surname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        return $stmt->execute();
    }

}