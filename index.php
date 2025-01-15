<?php
require_once __DIR__ . '/autoloader.php';
require_once __DIR__ . '/entries/api.php';
require_once __DIR__ . '/entries/views.php';

use Router\AllowedMethods;
use Router\Router;

$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

Router::execute($url, AllowedMethods::tryFrom($method) ?? AllowedMethods::UNSUPPORTED);

