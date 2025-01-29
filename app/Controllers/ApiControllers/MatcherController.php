<?php

namespace Controllers\ApiControllers;

use Models\User;
use Models\UserMatch;
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

    /**
     * 1. Get user and it's preferred sex
     * 2. Fetch all potential matches
     * 3. Filter those which already has intent made by logged user
     * 4. Include profile of each potential match
     *
     * @return void
     */
    public function getPotentialMatches(): void
    {
        $user = AuthHelper::getUserFromSession();

        $userProfile = UserProfilesRepository::provideRepository()
            ->getUserProfile($user->id);

        $potentialMatches = UserRepository::provideRepository()
            ->getUsersBySex($userProfile->preferredSex);

        $matchesDone = UserMatchRepository::provideRepository()
            ->getUserIntentMatches($user->id);

        $matchesDone = array_map(fn(UserMatch $match) => $match->userSecondId, $matchesDone);
        $potentialMatches = array_filter($potentialMatches, function (User $potentialMatch) use ($matchesDone) {
            if(in_array($potentialMatch->id, $matchesDone)) {
                return false;
            }
            return true;
        });

        $potentialMatchesProfiles = UserProfilesRepository::provideRepository()
            ->getUserProfiles(array_map(fn(User $user) => $user->id, $potentialMatches));


        $potentialMatches = array_map(fn(User $user, UserProfile $userProfile) => $user->toApiResponse(['userProfile' => $userProfile->toApiResponse()]),
            $potentialMatches, $potentialMatchesProfiles);

        shuffle($potentialMatches);

        echo (new SuccessResponse($potentialMatches))
            ->toJson();
        // Wykluczyć z listy użytkowników samego siebie oraz osoby które nie są zainteresowane płcią osoby która swipuje
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