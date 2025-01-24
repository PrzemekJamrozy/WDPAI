<?php

use Controllers\ViewControllers\Admin\AdminViewController;
use Controllers\ViewControllers\AuthViewController;
use Controllers\ViewControllers\MainViewController;
use Router\Router;

Router::get('/login', [AuthViewController::class, 'loginView']);
Router::get('/register', [AuthViewController::class, 'registerView']);

Router::get('/', [MainViewController::class, 'indexView']);

Router::get('/matches', [MainViewController::class, 'matchesView']);
Router::get('/user-profile', [MainViewController::class, 'userProfileView']);
Router::get('/edit-profile', [MainViewController::class, 'editProfileView']);

//ADMIN
Router::get('/admin-panel', [AdminViewController::class, 'adminPanelView']);
Router::get('/admin-edit-profile', [AdminViewController::class, 'adminEditUserView']);