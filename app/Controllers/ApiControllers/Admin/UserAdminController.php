<?php

namespace Controllers\ApiControllers\Admin;

use Enums\UserSex;
use Models\Permission;
use Models\User;
use Repositories\PermissionRepository;
use Repositories\UserProfilesRepository;
use Repositories\UserRepository;
use Responses\ErrorResponse;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;
use Utils\Helpers\DatabaseHelper;
use Utils\Helpers\FileHelper;
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

        $data = array_merge(RequestHelper::getPostData(), RequestHelper::getFilesFromRequest());

        RequestHelper::validateInput([
            "userId", 'email', 'password', 'preferredSex', 'permissions', 'avatar', 'igLink', 'fbLink', 'bio'
        ], $data);

        //Required to decode array in form data (js fetch)
        $data['permissions'] = json_decode($data['permissions'],false);
        $saveResult = FileHelper::uploadAvatar($data['avatar']);

        $repository = UserRepository::provideRepository();
        $user = $repository->getUserById($data['userId']);


        $result = DatabaseHelper::transaction(function () use ($user, $data, $repository, $saveResult) {
            $userUpdateResult = $repository
                ->updateUser($user->id, $user->name, $user->surname, $data['email'], AuthHelper::hashPassword($data['password']), $user->sex);

            $syncUserPermsResult = PermissionRepository::provideRepository()
                ->syncPermissionsToUser($user->id, $data['permissions']);

            $setUserAvatar = UserRepository::provideRepository()
                ->setUserAvatar($user->id, $saveResult);
            $userProfileResult = UserProfilesRepository::provideRepository()
                ->updateUserProfile($user->id, UserSex::from($data['preferredSex']), $data['bio'], $data['fbLink'], $data['igLink']);

            return $userUpdateResult && $syncUserPermsResult && $setUserAvatar && $userProfileResult;
        });

        if (!$result) {
            echo (new ErrorResponse(['message' => 'There was a problem while updating user']))
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

    public function getUser(): void
    {
        $this->hasAdminPermission();
        $data = RequestHelper::getGetData();
        RequestHelper::validateInput(['user_id'], $data);
        $user = UserRepository::provideRepository()->getUserById($data['user_id']);

        $userProfile = UserProfilesRepository::provideRepository()
            ->getUserProfile($user->id);

        $userPerms = PermissionRepository::provideRepository()
            ->getUsersPermissions($user->id);

        $userPerms = array_map(fn(Permission $perm) => $perm->toApiResponse(), $userPerms);


        echo (new SuccessResponse($user->toApiResponse([
            'userProfile' => $userProfile->toApiResponse(),
            'permissions' => $userPerms
        ])))->toJson();
    }

    public function getAllSystemPermissions(): void
    {
        $this->hasAdminPermission();
        $permissions = PermissionRepository::provideRepository()->getAllModels();

        $permissions = array_map(fn(array $permission) => Permission::fromData($permission)->toApiResponse(), $permissions);

        echo (new SuccessResponse($permissions))
            ->toJson();
    }
}