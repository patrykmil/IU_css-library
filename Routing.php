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
        } else {
            require_once "src/controllers/StartController.php";
            $controller = StartController::getInstance();
            $action = 'start';
        }

        $controller->$action();
    }
}
