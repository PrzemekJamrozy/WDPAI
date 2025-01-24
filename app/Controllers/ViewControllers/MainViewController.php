<?php

namespace Controllers\ViewControllers;

use Utils\Helpers\AuthHelper;

class MainViewController extends BaseViewController
{

    public function indexView(): void{
        if (!AuthHelper::isSessionSet()){
            $this->render("index");
            return;
        }

        $user = AuthHelper::getUserFromSession();

        if (!$user->hadOnboarding){
            $this->render('onboarding');
        }
        else{
            $this->render('main');
        }
    }

    public function matchesView(): void{
        $this->render("matches");
    }

    public function userProfileView(): void
    {
        $this->render('user-profile');
    }

    public function editProfileView(): void
    {
        $this->render('edit-profile');
    }
}