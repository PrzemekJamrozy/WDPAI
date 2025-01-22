<?php

namespace Repositories;

use Enums\UserSex;

class UserProfilesRepository extends BaseRepository
{
    public function provideTableName(): string
    {
        return 'user_profiles';
    }

    public function createUserProfile(int $userId, UserSex $preferredSex, string $userBio, string $fbLink, string $igLink): bool{
        $sql = "INSERT INTO users_profiles (user_id, preferred_sex, user_bio, facebook_link, instagram_link) VALUES (:userId, :preferredSex, :userBio, :facebookLink, :instagramLink)";
        return $this->database->connection->prepare($sql)->execute([
            'userId' => $userId,
            'preferredSex' => $preferredSex,
            'userBio' => $userBio,
            'facebookLink' => $fbLink,
            'instagramLink' => $igLink
        ]);
    }

}