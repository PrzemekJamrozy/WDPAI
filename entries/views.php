<?php

use Controllers\ViewControllers\AuthViewController;
use Router\Router;

Router::get('/', [AuthViewController::class, 'showTestFile']);