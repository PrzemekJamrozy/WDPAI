<?php

use Controllers\ApiControllers\Admin\UserAdminController;
use Controllers\ApiControllers\AuthController;
use Controllers\ApiControllers\DebugController;
use Controllers\ApiControllers\MatcherController;
use Controllers\ApiControllers\UserController;
use Router\Router;


// AUTH
Router::post('/api/register', [AuthController::class, 'register']);
Router::post('/api/login', [AuthController::class, 'login']);
Router::post('/api/logout', [AuthController::class, 'logout']);

// USER
Router::get('/api/user', [UserController::class, 'getCurrentUser']);
Router::post('/api/user/onboarding', [UserController::class, 'finishUserOnboarding']);


// MATCHES
Router::get('/api/match/get-potential-matches', [MatcherController::class, 'getPotentialMatches']);
Router::get('/api/match/get-matches', [MatcherController::class, 'getMatches']);
Router::post('/api/match/accept-match', [MatcherController::class, 'acceptMatch']);

//DEBUG
Router::get('/api/debug', [DebugController::class, 'debug']);
Router::post('/api/debug', [DebugController::class, 'debugPost']);

//ADMIN ENDPOINTS
Router::post('/api/admin/create-user', [UserAdminController::class, 'createUser']);
Router::post('/api/admin/update-user', [UserAdminController::class, 'updateUser']);
Router::post('/api/admin/delete-user', [UserAdminController::class, 'deleteUser']);
Router::get('/api/admin/users', [UserAdminController::class, 'getUsers']);
