<?php

class Routing
{
    private static array $routes = [
        'create' => ['controller' => 'CreateController', 'method' => 'create'],
        'component' => ['controller' => 'ComponentController', 'method' => 'component'],
        'register' => ['controller' => 'SecurityController', 'method' => 'register'],
        'login' => ['controller' => 'SecurityController', 'method' => 'login'],
        'logout' => ['controller' => 'SecurityController', 'method' => 'logout'],
        'start' => ['controller' => 'StartController', 'method' => 'start'],
        'browse' => ['controller' => 'BrowseController', 'method' => 'browse'],
        'createSet' => ['controller' => 'CreateController', 'method' => 'createSet'],
        'test' => ['controller' => 'StartController', 'method' => 'test'],
        '' => ['controller' => 'StartController', 'method' => 'start']
    ];

    public static function run($url): void
    {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];
        $id = isset($urlParts[1]) ? (int)$urlParts[1] : null;
        $controller = null;

        if (array_key_exists($action, self::$routes)) {
            $route = self::$routes[$action];
            require_once "src/controllers/{$route['controller']}.php";
            $controller = call_user_func([$route['controller'], 'getInstance']);
            $method = $route['method'];
        } else {
            require_once "src/controllers/ErrorController.php";
            $controller = ErrorController::getInstance();
            $method = 'error404';
        }
        if ($id !== null) {
            $controller->$method($id);
        } else {
            $controller->$method();
        }
    }
}