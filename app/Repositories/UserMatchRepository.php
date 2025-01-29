<?php

namespace Repositories;

use Models\User;
use Models\UserMatch;
use PDO;

class UserMatchRepository extends BaseRepository
{
    public function provideTableName(): string
    {
        return 'user_matches';
    }

    public function getUserMatchWithPerson(int $userIdWantingToMatch, int $userIdMatched): UserMatch|false
    {
        $sql = 'SELECT * from user_matches where user_first_id = :userIdWantingToMatch and user_second_id = :userIdMatched;';

        $stmt = $this->database->connection->prepare($sql);
        $stmt->execute([
            ':userIdWantingToMatch' => $userIdWantingToMatch,
            ':userIdMatched' => $userIdMatched
        ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$data){
            return false;
        }

        return UserMatch::fromData($data);
    }

    public function setUserSecondWanting(int $firstUserId, int $secondUserId, bool $isWanting = true): bool
    {
        $sql = "UPDATE user_matches set second_want_match = :isWanting where user_second_id = :secondUserId AND user_first_id = :firstUserId;";
        $stmt =  $this->database->connection->prepare($sql);
        return $stmt->execute([
            ':secondUserId' => $secondUserId,
            ':firstUserId' => $firstUserId,
            ':isWanting' => $isWanting
        ]);
    }

    public function createUserMatch(int $firstUserId, int $secondUserId): bool
    {
        $sql = "INSERT INTO user_matches(user_first_id, user_second_id, first_want_match, second_want_match) VALUES 
                (:firstUserId, :secondUserId, TRUE, FALSE);";
        return $this->database->connection->prepare($sql)->execute([
            ':firstUserId' => $firstUserId,
            ':secondUserId' => $secondUserId
        ]);
    }


    /**
     * Returns matches that were made by user (first_user_id)
     *
     * @return array<int,UserMatch>|false
     */
    public function getUserIntentMatches(int $userId):array|false
    {
        $sql = "SELECT * FROM user_matches where user_first_id = :userId";
        $stmt = $this->database->connection->prepare($sql);
        $stmt->execute([
            ':userId' => $userId
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($data === false){
            return false;
        }
        $matches = [];
        foreach ($data as $userMatch){
            $matches[] = UserMatch::fromData($userMatch);
        }

        return $matches;
    }

    /**
     * @param int $userId
     * @return array<int, User>
     */
    public function getUsersWhichAreMatched(int $userId): array
    {
        $sql = 'SELECT DISTINCT u.*
                FROM users u
                JOIN (
                    SELECT 
                        CASE 
                            WHEN user_first_id = :logged_user_id THEN user_second_id
                            WHEN user_second_id = :logged_user_id THEN user_first_id
                        END AS user_id
                    FROM user_matches
                    WHERE :logged_user_id IN (user_first_id, user_second_id) AND show_match = TRUE
                ) matched_users ON u.id = matched_users.user_id;';

        $stmt = $this->database->connection->prepare($sql);
        $stmt->execute([
            ':logged_user_id' => $userId
        ]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$data){
            return [];
        }
        $users = [];
        foreach ($data as $row) {
            $users[] = User::fromData($row);
        }
        return $users;
    }
}