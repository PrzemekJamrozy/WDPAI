<?php

namespace Controllers\ApiControllers\Admin;

use Permissions\Permissions;
use Repositories\PermissionRepository;
use Responses\ErrorResponse;
use Utils\Helpers\AuthHelper;

abstract class BaseAdminController
{
    protected function hasAdminPermission(): void
    {
        $user = AuthHelper::getUserFromSessionSession();
        $result = PermissionRepository::provideRepository()->hasPermission($user, Permissions::PERMISSION_ADMIN);
        if (!$result) {
            die(
            (new ErrorResponse(['message' => 'User is not permitted to perform this action']))
                ->toJson()
            );
        }
    }
}