<?php

namespace Controllers\ViewControllers;

class AuthViewController extends BaseViewController
{
    public function showTestFile(){
        $this->render('test', ['test' => 123]);
    }
}