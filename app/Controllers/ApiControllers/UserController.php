<?php

namespace Controllers\ApiControllers;

use Enums\UserSex;
use Exception;
use Models\Permission;
use Repositories\PermissionRepository;
use Repositories\UserProfilesRepository;
use Repositories\UserRepository;
use Responses\ErrorResponse;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;
use Utils\Helpers\DatabaseHelper;
use Utils\Helpers\FileHelper;
use Utils\Helpers\RequestHelper;

class UserController
{

    public function getCurrentUser(): void
    {
        $user = AuthHelper::getUserFromSession();
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

    /**
     * @return void
     * @throws Exception
     */
    public function finishUserOnboarding(): void
    {
        $data = array_merge(RequestHelper::getPostData(), RequestHelper::getFilesFromRequest());

        RequestHelper::validateInput(['bio', 'fbLink', 'igLink', 'sex', 'avatar'], $data);
        $saveResult = FileHelper::uploadAvatar($data['avatar']);

        if (!$saveResult) {
            echo (new ErrorResponse(['message' => "Couldn't upload avatar"]))
                ->toJson();
            return;
        }
        $user = AuthHelper::getUserFromSession();

        $result = DatabaseHelper::transaction(function () use ($user, $data, $saveResult) {
            $userProfileResult = UserProfilesRepository::provideRepository()
                ->createUserProfile($user->id, UserSex::from($data['sex']), $data['bio'], $data['fbLink'], $data['igLink']);

            $updateOnboardingResult = UserRepository::provideRepository()
                ->setUserOnboardingStatus($user->id, true);

            $setUserAvatar = UserRepository::provideRepository()
                ->setUserAvatar($user->id, $saveResult);

            return $userProfileResult && $updateOnboardingResult && $setUserAvatar;
        });

        if (!$result) {
            echo (new ErrorResponse(['message' => "Couldn't finish user onboarding"]))
                ->toJson();
            return;
        }

        echo (new SuccessResponse([]))
            ->toJson();
    }

    public function updateUser(): void
    {
        $data = array_merge(RequestHelper::getPostData(), RequestHelper::getFilesFromRequest());
        RequestHelper::validateInput([
            'fbLink',
            'igLink',
            'bio',
            'preferredSex',
            'email',
            'password',
            'avatar',
        ], $data);

        $saveResult = FileHelper::uploadAvatar($data['avatar']);

        if (!$saveResult) {
            echo (new ErrorResponse(['message' => "Couldn't upload avatar"]))
                ->toJson();
            return;
        }
        $user = AuthHelper::getUserFromSession();

        $result = DatabaseHelper::transaction(function () use ($user, $data, $saveResult) {
            $userProfileResult = UserProfilesRepository::provideRepository()
                ->updateUserProfile($user->id, UserSex::from($data['preferredSex']), $data['bio'], $data['fbLink'], $data['igLink']);

            $userEditResult = UserRepository::provideRepository()
                ->updateUser($user->id, $user->name, $user->surname, $data['email'], AuthHelper::hashPassword($data['password']), $user->sex);

            $setUserAvatar = UserRepository::provideRepository()
                ->setUserAvatar($user->id, $saveResult);

            return $userProfileResult && $setUserAvatar && $userEditResult;
        });

        if (!$result) {
            echo (new ErrorResponse(['message' => "Couldn't update user"]))
                ->toJson();
            return;
        }

        echo (new SuccessResponse([]))
            ->toJson();
    }

    public function deleteUser(): void
    {
        $user = AuthHelper::getUserFromSession();

        $result = UserRepository::provideRepository()
            ->deleteUser($user->id);

        if (!$result) {
            echo (new ErrorResponse(['message' => "Couldn't delete user"]))
                ->toJson();
        } else {
            AuthHelper::destroyUserSession();
            echo (new SuccessResponse([]))
                ->toJson();
        }
    }
}