<?php

namespace Controllers\ApiControllers;

use Models\User;
use Repositories\PermissionRepository;
use Repositories\UserRepository;
use Responses\ErrorResponse;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;
use Utils\Helpers\RequestHelper;

class AuthController
{

    public function login(): void
    {
        $data = RequestHelper::getPostData();
        RequestHelper::validateInput(['email', 'password'], $data);

        $user = UserRepository::provideRepository()
            ->getUserByEmail($data['email']);

        if (!$user) {
            echo (new ErrorResponse(['message' => 'Invalid credentials']))
                ->toJson();

            return;
        }

        $isValidPassword = AuthHelper::verifyPassword($data['password'], $user->password);
        if (!$isValidPassword) {
            echo (new ErrorResponse(['message' => 'Invalid credentials']))
                ->toJson();
            return;
        }
        AuthHelper::createUserSession($user);

        echo (new SuccessResponse([]))
            ->toJson();
    }

    public function logout(): void
    {
        AuthHelper::destroyUserSession();
        echo (new SuccessResponse([]))
            ->toJson();
    }

    public function register(): void
    {
        $data = RequestHelper::getPostData();
        RequestHelper::validateInput(['name', 'surname', 'email', 'password', 'sex'], $data);

        $repository = UserRepository::provideRepository();

        $userExists = $repository->getUserByEmail($data['email']);
        if ($userExists) {
            echo (new ErrorResponse(['message' => 'User with given email already exists']))
                ->toJson();
            return;
        }

        $result = $repository
            ->createUser($data['name'], $data['surname'], $data['email'], AuthHelper::hashPassword($data['password']), $data['sex']);

        $user = UserRepository::provideRepository()
            ->getUserByEmail($data['email']);

        // Permission id 2 is always PERMISSION_USER after init seeding
        PermissionRepository::provideRepository()
            ->assignPermissionToUser($user->id, 2);

        if ($result) {
            unset($data['password']);
            echo (new SuccessResponse($data))
                ->toJson();
        } else {
            echo (new ErrorResponse(['message' => 'There was a problem registering your account']))
                ->toJson();
        }
    }

}