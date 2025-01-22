<?php

use Controllers\ViewControllers\AuthViewController;
use Controllers\ViewControllers\MainViewController;
use Router\Router;

Router::get('/login', [AuthViewController::class, 'loginView']);
Router::get('/register', [AuthViewController::class, 'registerView']);

Router::get('/', [MainViewController::class, 'index']);