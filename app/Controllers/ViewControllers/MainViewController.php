<?php

namespace Controllers\ViewControllers;

use Utils\Helpers\AuthHelper;

class MainViewController extends BaseViewController
{

    public function index(): void{
        if (!AuthHelper::isSessionSet()){
            $this->render("index");
            return;
        }

        $user = AuthHelper::getUserFromSessionSession();

        if (!$user->hadOnboarding){
            $this->render('onboarding');
        }
        else{
            $this->render('main');
        }
    }
}