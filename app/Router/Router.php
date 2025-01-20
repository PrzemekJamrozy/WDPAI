<?php

namespace Router;

use Controllers\ViewControllers\CommonViewController;
use Exception;
use Throwable;
use Utils\Helpers\RouterHelpers;

class Router
{
    protected static array $routes = [
        "GET" => [],
        "POST" => [],
    ];


    public static function get(string $url, array $action): void
    {
        Router::$routes["GET"][] = Router::createRoute($url, $action);
    }

    public static function post(string $url, array $action): void
    {
        Router::$routes["POST"][] = Router::createRoute($url, $action);
    }

    private static function createRoute(string $url, array $action): array
    {
        return [$url, $action];
    }

    public static function execute(string $url, AllowedMethods $method): void
    {
        if ($method === AllowedMethods::UNSUPPORTED) {
            die('Method not allowed');
        }

        $action = RouterHelpers::findRequest($url, Router::$routes[$method->value]);
        if ($action) {
            $controller = new $action[1][0]();
            $controller->{$action[1][1]}();
        }else{
            $controller = new CommonViewController();
            $controller->error404();
        }
    }
}