<?php

namespace Models;

use Enums\UserSex;

class UserProfile extends Model
{

    public int $id;
    public int $userId;
    public UserSex $preferredSex;
    public string $userBio;
    public string $facebookLink;
    public string $instagramLink;

    /**
     * @param int $id
     * @param int $userId
     * @param UserSex $preferredSex
     * @param string $userBio
     * @param string $facebookLink
     * @param string $instagramLink
     */
    public function __construct(int $id, int $userId, UserSex $preferredSex, string $userBio, string $facebookLink, string $instagramLink)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->preferredSex = $preferredSex;
        $this->userBio = $userBio;
        $this->facebookLink = $facebookLink;
        $this->instagramLink = $instagramLink;
    }


    public static function fromData(array $data): static
    {
        return new static(
            $data['id'],
            $data['user_id'],
            UserSex::from($data['preferred_sex']),
            $data['user_bio'],
            $data['facebook_link'],
            $data['instagram_link'],
        );
    }

    public function toApiResponse(array $with = []): array
    {
        return array_merge([
            'id' => $this->id,
            'userId' => $this->userId,
            'preferredSex' => $this->preferredSex,
            'userBio' => $this->userBio,
            'facebookLink' => $this->facebookLink,
            'instagramLink' => $this->instagramLink,
        ], $with);
    }

}