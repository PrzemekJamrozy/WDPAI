<?php

namespace Controllers\ApiControllers;

use Models\User;
use Models\UserProfile;
use Repositories\UserMatchRepository;
use Repositories\UserProfilesRepository;
use Repositories\UserRepository;
use Responses\ErrorResponse;
use Responses\SuccessResponse;
use Utils\Helpers\AuthHelper;
use Utils\Helpers\RequestHelper;

class MatcherController
{

    public function getPotentialMatches(): void
    {
        $user = AuthHelper::getUserFromSession();

        $userProfile = UserProfilesRepository::provideRepository()
            ->getUserProfile($user->id);

        $potentialMatches = UserRepository::provideRepository()
            ->getUsersBySex($userProfile->preferredSex);

        $potentialMatchesProfiles = UserProfilesRepository::provideRepository()
            ->getUserProfiles(array_map(fn(User $user) => $user->id, $potentialMatches));


        $potentialMatches = array_map(fn(User $user, UserProfile $userProfile) => $user->toApiResponse(['userProfile' => $userProfile->toApiResponse()]),
            $potentialMatches, $potentialMatchesProfiles);

        shuffle($potentialMatches);

        echo (new SuccessResponse($potentialMatches))
            ->toJson();
        // Zrobić piorytet jeżeli dany użytkownik ma match'a od kogoś innego
        // Wykluczyć z listy użytkowników samego siebie oraz osoby które nie są zainteresowane płcią osoby która swipuje
        // filtr osób które są są matchowane po stronie użytkownika
    }

    public function acceptMatch(): void
    {
        $user = AuthHelper::getUserFromSession();
        $data = RequestHelper::getPostData();
        RequestHelper::validateInput(['userId'], $data);

        $userMatchRepository = UserMatchRepository::provideRepository();
        $match = $userMatchRepository->getUserMatchWithPerson($data['userId'], $user->id);

        if ($match) {
            $result = $userMatchRepository->setUserSecondWanting($data['userId'], $user->id);
        } else {
            $result = $userMatchRepository->createUserMatch($user->id, $data['userId']);
        }

        if (!$result) {
            echo (new ErrorResponse(['message' => 'User match could not be created']))
                ->toJson();
        } else {
            echo (new SuccessResponse([]))
                ->toJson();
        }
    }

    public function getMatches(): void
    {
        $user = AuthHelper::getUserFromSession();

        $matchUsers = UserMatchRepository::provideRepository()
            ->getUsersWhichAreMatched($user->id);

        $potentialMatchesProfiles = UserProfilesRepository::provideRepository()
            ->getUserProfiles(array_map(fn(User $user) => $user->id, $matchUsers));

        echo (new SuccessResponse(array_map(fn(User $user, UserProfile $userProfile) => $user->toApiResponse(['userProfile' => $userProfile->toApiResponse()]), $matchUsers, $potentialMatchesProfiles)))
            ->toJson();
    }

}