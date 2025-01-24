<?php

namespace Controllers\ViewControllers\Admin;

use Controllers\ViewControllers\BaseViewController;

class AdminViewController extends BaseViewController
{

    public function adminPanelView():void{
        $result = $this->hasAdminPermission();

        if(!$result){
            $this->render('error404');
            return;
        }
        $this->render('admin-panel');
    }

    public function adminEditUserView():void{
        $result = $this->hasAdminPermission();

        if(!$result){
            $this->render('error404');
            return;
        }
        $this->render('admin-edit-profile');
    }



}