<?php

namespace Controllers\ApiControllers;

use Models\User;
use Models\UserProfile;
use Repositories\PermissionRepository;
use Repositories\UserMatchRepository;
use Repositories\UserProfilesRepository;
use Repositories\UserRepository;
use Responses\ErrorResponse;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;
use Utils\Helpers\FileHelper;
use Utils\Helpers\RequestHelper;

class DebugController
{

    public function debug(): void
    {
        $user = AuthHelper::getUserFromSession();

        $matchUsers = UserMatchRepository::provideRepository()
            ->getUsersWhichAreMatched($user->id);

        $potentialMatchesProfiles = UserProfilesRepository::provideRepository()
            ->getUserProfiles(array_map(fn(User $user) => $user->id, $matchUsers));

        echo (new SuccessResponse(array_map(fn(User $user, UserProfile $userProfile) => $user->toApiResponse(['userProfile' => $userProfile]), $matchUsers, $potentialMatchesProfiles)))
            ->toJson();
    }

    public function debugPost(): void{
        $data = RequestHelper::getFilesFromRequest();
        $result = FileHelper::uploadAvatar($data['file']);

        if (!$result) {
            echo (new ErrorResponse(['message'=>"Couldn't save file"]))
                ->toJson();
            return;
        }
        echo (new SuccessResponse(['message'=>$result]))
            ->toJson();
    }

}