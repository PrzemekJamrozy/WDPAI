<?php

namespace Controllers\ApiControllers;

use Repositories\UserProfilesRepository;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;
use Utils\Helpers\RequestHelper;

class UserController
{

    public function getCurrentUser(): void
    {
        $user = AuthHelper::getUserFromSessionSession();

        echo (new SuccessResponse($user->toApiResponse()))
            ->toJson();
    }

    public function finishUserOnboarding(): void{
        $data = RequestHelper::getPostData();
        RequestHelper::validateInput(['bio', 'fbLink', 'igLink', 'sex', 'avatar'], $data);

        $user = AuthHelper::getUserFromSessionSession();

        UserProfilesRepository::provideRepository()
            ->createUserProfile($user->id,$data['sex'],$data['bio'],$data['fbLink'],$data['igLink']);


    }
}