<?php
require_once "src/controllers/ComponentController.php";
require_once "src/controllers/SecurityController.php";
require_once "src/controllers/StartController.php";

class Routing
{
    public static function run($url)
    {
        $action = explode("/", $url)[0];
        $controller = null;
        /*
        if (!array_key_exists($action, self::$routes)) {
          die("Wrong url!");
        }
        */
        if (in_array($action, ["component"])) {
            $controller = ComponentController::getInstance();
            $action = 'component';
        } elseif (in_array($action, ["register", "login"])) {
            $controller = SecurityController::getInstance();
            $action = 'login';
        } else {
            $controller = StartController::getInstance();
            $action = 'start';
        }

        $controller->$action();
    }
}
