<?php

namespace Controllers\ApiControllers\Admin;

use Models\User;
use Repositories\PermissionRepository;
use Repositories\UserRepository;
use Responses\ErrorResponse;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;
use Utils\Helpers\RequestHelper;

class UserAdminController extends BaseAdminController
{
    public function createUser(): void
    {
        $this->hasAdminPermission();

        $data = RequestHelper::getPostData();
        RequestHelper::validateInput(['name', 'surname', 'email', 'password', 'sex', 'permissionsId'], $data);

        $repository = UserRepository::provideRepository();
        $userCreateResult = $repository
            ->createUser($data['name'], $data['surname'], $data['email'], AuthHelper::hashPassword($data['password']), $data['sex']);

        if (!$userCreateResult) {
            echo (new ErrorResponse(['message' => 'There was a problem while creating new user']))
                ->toJson();
            return;
        }

        $user = $repository->getUserByEmail($data['email']);

        $syncUserPermsResult = PermissionRepository::provideRepository()
            ->assignPermissionsToUser($user->id, $data['permissionsId']);

        if (!$syncUserPermsResult) {
            echo (new ErrorResponse(['message' => 'There was a problem while assigning permissions to user']))
                ->toJson();
            return;
        }

        echo (new SuccessResponse(['user' => $user->toApiResponse()]))
            ->toJson();
    }

    public function updateUser(): void
    {
        $this->hasAdminPermission();

        $data = RequestHelper::getPostData();
        RequestHelper::validateInput(["userId", 'name', 'surname', 'email', 'password', 'sex', 'permissionsId'], $data);

        $repository = UserRepository::provideRepository();
        $userUpdateResult = $repository
            ->updateUser($data["userId"], $data['name'], $data['surname'], $data['email'], AuthHelper::hashPassword($data['password']), $data['sex']);

        if (!$userUpdateResult) {
            echo (new ErrorResponse(['message' => 'There was a problem while updating new user']))
                ->toJson();
            return;
        }

        $user = $repository->getUserByEmail($data['email']);

        $syncUserPermsResult = PermissionRepository::provideRepository()
            ->syncPermissionsToUser($user->id, $data['permissionsId']);

        if (!$syncUserPermsResult) {
            echo (new ErrorResponse(['message' => 'There was a problem while assigning permissions to user']))
                ->toJson();
            return;
        }

        echo (new SuccessResponse(['user' => $user->toApiResponse()]))
            ->toJson();
    }

    public function deleteUser(): void
    {
        $this->hasAdminPermission();
        $data = RequestHelper::getPostData();
        RequestHelper::validateInput(['userId'], $data);
        $result = UserRepository::provideRepository()->deleteUser($data['userId']);

        if (!$result) {
            echo (new ErrorResponse(['message' => 'There was a problem while deleting user']))
                ->toJson();
        }

        echo (new SuccessResponse([]))
            ->toJson();
    }

    public function getUsers(): void
    {
        $this->hasAdminPermission();
        $users = UserRepository::provideRepository()->getAllModels();
        $users = array_map(fn(array $user) => User::fromData($user)->toApiResponse(), $users);

        echo (new SuccessResponse(['users' => $users]))
            ->toJson();
    }
}