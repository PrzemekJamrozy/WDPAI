<?php

namespace Seeder;

class UserSeeder extends BaseSeeder
{
    public function seed():void
    {
        $password = password_hash("password", PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, surname, email, password, sex, had_onboarding, avatar_url)  VALUES
                ('Anna', 'Kowalska', 'anna.kowalska@example.com', :password ,'FEMALE', true,'uploads/avatars/woman-one.jpg' ),
                ('Katarzyna', 'Nowak', 'katarzyna.nowak@example.com',:password, 'FEMALE', true, 'uploads/avatars/woman-two.jpg'),
                ('Joanna', 'Wiśniewska', 'joanna.wisniewska@example.com',:password, 'FEMALE', true, 'uploads/avatars/woman-three.jpg'),
                ('Magdalena', 'Jankowska', 'magdalena.jankowska@example.com',:password, 'FEMALE', true, 'uploads/avatars/woman-four.jpg'),
                ('Marta', 'Wojciechowska', 'marta.wojciechowska@example.com', :password,'FEMALE', true, 'uploads/avatars/woman-five.jpg'),
                ('Adam', 'Kowalski', 'adam.kowalski@example.com', :password,'MALE', true, 'uploads/avatars/man-one.jpg'),
                ('Paweł', 'Nowak', 'pawel.nowak@example.com',:password, 'MALE', true, 'uploads/avatars/man-two.jpg'),
                ('Tomasz', 'Wiśniewski', 'tomasz.wisniewski@example.com',:password, 'MALE', true, 'uploads/avatars/man-three.jpg'),
                ('Piotr', 'Wojciechowski', 'piotr.wojciechowski@example.com',:password, 'MALE', true, 'uploads/avatars/man-four.jpg'),
                ('Przemysław', 'Jamrozy', 'admin@datespark.pl', :password,'MALE', true, 'uploads/avatars/man-five.jpg');
                ";

        $this->database->connection->prepare($sql)->execute([
            ':password' => $password
        ]);
    }


}