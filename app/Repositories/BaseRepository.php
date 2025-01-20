<?php

namespace Repositories;

use Database\DatabaseProvider;
use PDO;
use PDOException;

abstract class BaseRepository
{

    protected DatabaseProvider $database;

    protected function __construct()
    {
        $this->database = DatabaseProvider::getInstance();
    }

    public abstract function provideTableName(): string;


    /**
     * @return array<int,mixed>
     */
    public function getAllModels(): array
    {
        $stmt = $this->database->connection->prepare("SELECT * FROM " . $this->provideTableName());
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function getModelById(int $id): array
    {
        $stmt = $this->database->connection->prepare("SELECT * FROM " . $this->provideTableName() . " WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function asTransaction(callable $functionCall): bool {
        try{
            $this->database->connection->beginTransaction();
            $functionCall();
            return $this->database->connection->commit();
        } catch (PDOException $e) {
            echo $e->getMessage();
            $this->database->connection->rollBack();
            return false;
        }

    }

    public static function provideRepository(): static{
        return new static();
    }
}