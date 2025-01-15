<?php
use Controllers\ApiControllers\AuthController;
use Router\Router;

Router::get('/api', [AuthController::class, 'login']);
