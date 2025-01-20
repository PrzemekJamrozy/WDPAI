<?php

namespace Controllers\ApiControllers;

use Repositories\PermissionRepository;
use Repositories\UserRepository;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;

class DebugController
{

    public function debug(): void
    {
        echo (new SuccessResponse(UserRepository::provideRepository()->getUserById(4)->toApiResponse()))
            ->toJson();
    }

}