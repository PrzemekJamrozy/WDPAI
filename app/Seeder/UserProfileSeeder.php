<?php

namespace Seeder;

class UserProfileSeeder extends BaseSeeder
{
    public function seed(): void
    {
        $sql = "INSERT INTO users_profiles (user_id, preferred_sex, user_bio, facebook_link, instagram_link) VALUES 
                (1, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (2, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (3, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (4, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (5, 'MALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (6, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (7, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (8, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (9, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/'),
                (10, 'FEMALE', 'MyBio', 'https://www.facebook.com/przemek.jamrozy.1', 'https://www.instagram.com/_jamrozy_/');
                ";

        $this->database->connection->exec($sql);
    }


}