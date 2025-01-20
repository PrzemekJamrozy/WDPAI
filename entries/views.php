<?php

use Controllers\ViewControllers\AuthViewController;
use Router\Router;

Router::get('/login', [AuthViewController::class, 'loginView']);
Router::get('/register', [AuthViewController::class, 'registerView']);