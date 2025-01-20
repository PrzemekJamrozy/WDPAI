<?php

namespace Controllers\ViewControllers;

class CommonViewController extends BaseViewController
{

    public function error404(): void
    {
        $this->render("error404");
    }

}