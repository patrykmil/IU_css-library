<?php

class Routing
{
    private static $routes = [
        'create' => ['controller' => 'CreateController', 'method' => 'component'],
        'component' => ['controller' => 'ComponentController', 'method' => 'component'],
        'register' => ['controller' => 'SecurityController', 'method' => 'register'],
        'login' => ['controller' => 'SecurityController', 'method' => 'login'],
        'start' => ['controller' => 'StartController', 'method' => 'start'],
        '' => ['controller' => 'StartController', 'method' => 'start']
    ];

    public static function run($url)
    {
        $action = explode("/", $url)[0];
        $controller = null;

        if (array_key_exists($action, self::$routes)) {
            $route = self::$routes[$action];
            require_once "src/controllers/{$route['controller']}.php";
            $controller = call_user_func([$route['controller'], 'getInstance']);
            $method = $route['method'];
        } else {
            require_once "src/controllers/E404Controller.php";
            $controller = E404Controller::getInstance();
            $method = 'e404';
        }

        $controller->$method();
    }
}

/*
 <?php

class Routing
{
    public static function run($url)
    {
        $action = explode("/", $url)[0];
        $controller = null;

        if (in_array($action, ["component"])) {
            require_once "src/controllers/ComponentController.php";
            $controller = ComponentController::getInstance();
            $action = 'component';
        } elseif (in_array($action, ["register", "login"])) {
            require_once "src/controllers/SecurityController.php";
            $controller = SecurityController::getInstance();
            $action = 'login';
        } elseif (in_array($action, ["start", ""])) {
            require_once "src/controllers/StartController.php";
            $controller = StartController::getInstance();
            $action = 'start';
        } else {
            require_once "src/controllers/E404Controller.php";
            $controller = E404Controller::getInstance();
            $action = 'e404';
        }

        $controller->$action();
    }
}
*/
