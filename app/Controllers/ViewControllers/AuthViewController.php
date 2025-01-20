<?php

namespace Controllers\ViewControllers;

class AuthViewController extends BaseViewController
{
    public function loginView():void{
        $this->render('login');
    }

    public function registerView():void{
        $this->render('register');
    }
}