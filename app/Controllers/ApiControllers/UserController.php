<?php

namespace Controllers\ApiControllers;

use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;

class UserController
{

    public function getCurrentUser(): void
    {
        $user = AuthHelper::getUserFromSessionSession();

        echo (new SuccessResponse($user->toApiResponse()))
            ->toJson();
    }
}