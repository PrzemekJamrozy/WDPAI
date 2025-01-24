<?php

namespace Utils\Helpers;

use Database\DatabaseProvider;
use Exception;
use PDOException;

class DatabaseHelper
{
    private static ?DatabaseProvider $instance = null;

    protected static function withInstance(): DatabaseProvider
    {
        if (DatabaseHelper::$instance !== null) {
            return DatabaseHelper::$instance;
        }
        DatabaseHelper::$instance = DatabaseProvider::getInstance();
        return DatabaseHelper::$instance;
    }

    /**
     * @param callable $functionCall
     * @return bool
     * @throws Exception
     */
    public static function transaction(callable $functionCall): bool
    {
        try {
            DatabaseHelper::withInstance()->connection->beginTransaction();
            $result = $functionCall();
            return DatabaseHelper::withInstance()->connection->commit() && $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            DatabaseHelper::withInstance()->connection->rollBack();
            return false;
        }
    }
}