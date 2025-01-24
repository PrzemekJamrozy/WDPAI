<?php

namespace Seeder;

class UserProfileSeeder extends BaseSeeder
{
    public function seed(): void
    {
        $sql = "INSERT INTO users_profiles (user_id, preferred_sex, user_bio, facebook_link, instagram_link) VALUES 
                (1, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (2, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (3, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (4, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (5, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (6, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (7, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (8, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (9, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/'),
                (10, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/xsheeya/');
                ";

        $this->database->connection->exec($sql);
    }


}