<?php
require_once "src/controllers/ErrorController.php";
class Routing
{
    private static array $routes = [
        'create' => ['controller' => 'CreateController', 'method' => 'create'],
        'component' => ['controller' => 'ComponentController', 'method' => 'component'],
        'register' => ['controller' => 'SecurityController', 'method' => 'register'],
        'login' => ['controller' => 'SecurityController', 'method' => 'login'],
        'logout' => ['controller' => 'SecurityController', 'method' => 'logout'],
        'browse' => ['controller' => 'BrowseController', 'method' => 'browse'],
        'createSet' => ['controller' => 'CreateController', 'method' => 'createSet'],
        'toggleLike' => ['controller' => 'ComponentController', 'method' => 'toggleLike'],
        'collection' => ['controller' => 'CollectionController', 'method' => 'collection'],
        'deleteComponent' => ['controller' => 'CollectionController', 'method' => 'deleteComponent'],
        'adminDeleteComponent' => ['controller' => 'ComponentController', 'method' => 'adminDeleteComponent'],
        'start' => ['controller' => 'StartController', 'method' => 'start'],
        '' => ['controller' => 'StartController', 'method' => 'start']
    ];

    public static function run($url): void
    {
        $strategy = self::setRoute($url);
        $controller = $strategy['controller'];
        $method = $strategy['method'];
        $param = $strategy['param'] ?? null;
        $controller->$method($param);
    }

    public static function setRoute($url): array
    {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];
        $param = $urlParts[1] ?? null;
        $strategy = [];
        if (array_key_exists($action, self::$routes)) {
            $route = self::$routes[$action];
            require_once "src/controllers/{$route['controller']}.php";
            $strategy['controller'] = call_user_func([$route['controller'], 'getInstance']);
            $strategy['method'] = $route['method'];
            $strategy['param'] = $param;
        } else {
            $strategy['controller'] = ErrorController::getInstance();
            $strategy['method'] = 'error404';
        }
        return $strategy;
    }
}
