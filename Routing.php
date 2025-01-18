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
        'start' => ['controller' => 'StartController', 'method' => 'start'],
        'browse' => ['controller' => 'BrowseController', 'method' => 'browse'],
        'createSet' => ['controller' => 'CreateController', 'method' => 'createSet'],
        'toggleLike' => ['controller' => 'ComponentController', 'method' => 'toggleLike'],
        'collection' => ['controller' => 'CollectionController', 'method' => 'collection'],
        'deleteComponent' => ['controller' => 'CollectionController', 'method' => 'deleteComponent'],
        '' => ['controller' => 'StartController', 'method' => 'start']
    ];

    public static function run($url): void
    {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];
        $param = $urlParts[1] ?? null;
        $controller = null;

        if (array_key_exists($action, self::$routes)) {
            $route = self::$routes[$action];
            require_once "src/controllers/{$route['controller']}.php";
            $controller = call_user_func([$route['controller'], 'getInstance']);
            $method = $route['method'];
        } else {
            $controller = ErrorController::getInstance();
            $method = 'error404';
            $controller->$method();
        }
        $reflection = new ReflectionMethod($controller, $method);
        if ($reflection->getNumberOfRequiredParameters() > 0) {
            $controller->$method($param);
        } else {
            $controller->$method();
        }
    }
}
