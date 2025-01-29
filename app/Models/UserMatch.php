<?php

namespace Models;

class UserMatch extends Model
{

    public int $id;
    public int $userFirstId;
    public int $userSecondId;
    public bool $firstWantMatch;
    public bool $secondWantMatch;
    public bool $showMatch;

    /**
     * @param int $id
     * @param int $userFirstId
     * @param int $userSecondId
     * @param bool $firstWantMatch
     * @param bool $secondWantMatch
     * @param bool $showMatch
     */
    public function __construct(int $id, int $userFirstId, int $userSecondId, bool $firstWantMatch, bool $secondWantMatch, bool $showMatch)
    {
        $this->id = $id;
        $this->userFirstId = $userFirstId;
        $this->userSecondId = $userSecondId;
        $this->firstWantMatch = $firstWantMatch;
        $this->secondWantMatch = $secondWantMatch;
        $this->showMatch = $showMatch;
    }


    public static function fromData(array $data): static{
        return new static(
            $data['id'],
            $data['user_first_id'],
            $data['user_second_id'],
            $data['first_want_match'],
            $data['second_want_match'],
            $data['show_match']
        );
    }

    public function toApiResponse(array $with = []): array
    {
        return [
            "id" => $this->id,
            "userFirstId" => $this->userFirstId,
            "userSecondId" => $this->userSecondId,
            "firstWantMatch" => $this->firstWantMatch,
            "secondWantMatch" => $this->secondWantMatch,
            "showMatch" => $this->showMatch
        ];
    }

}