<?php

namespace Repositories;

use Enums\UserSex;
use Models\UserProfile;
use PDO;

class UserProfilesRepository extends BaseRepository
{
    public function provideTableName(): string
    {
        return 'user_profiles';
    }

    public function createUserProfile(int $userId, UserSex $preferredSex, string $userBio, string $fbLink, string $igLink): bool
    {
        $sql = "INSERT INTO users_profiles (user_id, preferred_sex, user_bio, facebook_link, instagram_link) VALUES (:userId, :preferredSex, :userBio, :facebookLink, :instagramLink)";
        return $this->database->connection->prepare($sql)->execute([
            ':userId' => $userId,
            ':preferredSex' => $preferredSex->value,
            ':userBio' => $userBio,
            ':facebookLink' => $fbLink,
            ':instagramLink' => $igLink
        ]);
    }

    public function updateUserProfile(int $userId, UserSex $preferredSex, string $userBio, string $fbLink, string $igLink): bool
    {
        $sql = "UPDATE users_profiles SET 
              preferred_sex = :preferredSex,
              user_bio = :userBio,
              facebook_link = :fbLink,
              instagram_link = :igLink
              WHERE user_id = :userId";
        return $this->database->connection->prepare($sql)->execute([
            ':userId' => $userId,
            ':preferredSex'=> $preferredSex->value,
            ':userBio' => $userBio,
            ':fbLink' => $fbLink,
            ':igLink' => $igLink
        ]);
    }
    /**
     * @param array<int,int> $userIds
     * @return array<int, UserProfile>
     */
    public function getUserProfiles(array $userIds): array
    {
        $userProfiles = [];
        foreach ($userIds as $userId) {
            $userProfiles[] =  $this->getUserProfile($userId);
        }
        return $userProfiles;
    }

    public function getUserProfile(int $userId): UserProfile
    {
        $sql = "SELECT * FROM users_profiles WHERE user_id = :userId";
        $stmt = $this->database->connection->prepare($sql);
        $stmt->execute([
            ':userId' => $userId
        ]);
        return UserProfile::fromData($stmt->fetch(PDO::FETCH_ASSOC));
    }

}