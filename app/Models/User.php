<?php

namespace Models;

use Enums\UserSex;

class User extends Model
{
    public int $id;
    public string $name;
    public string $surname;
    public string $email;
    public string $password;
    public UserSex $sex;
    public bool $hadOnboarding;
    public string $avatarUrl;

    public function __construct(int $id, string $name, string $surname, string $email, string $password, UserSex $sex,
    bool $hadOnboarding, string $avatarUrl)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
        $this->sex = $sex;
        $this->hadOnboarding = $hadOnboarding;
        $this->avatarUrl = $avatarUrl;
    }


    public static function fromData(array $data): static
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['surname'],
            $data['email'],
            $data['password'],
            UserSex::tryFrom($data['sex']) ?? UserSex::NOT_SPECIFIED,
            $data['had_onboarding'],
            $data['avatar_url']
        );
    }

    public function toApiResponse(array $with = []): array
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'sex' => $this->sex->value,
            'avatar' => $this->avatarUrl,
        ], $with);
    }


}