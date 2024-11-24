<?php
require_once "src/controllers/ComponentController.php";
require_once "src/controllers/SecurityController.php";
class Routing {
    public static function run ($url) {
        $action = explode("/", $url)[0];
        $controller = null;
        /*
        if (!array_key_exists($action, self::$routes)) {
          die("Wrong url!");
        }
        */
        if(in_array($action, ["component", ""])) {
            $controller = "ComponentController";
            $action = 'component';
        }
        
        if(in_array($action, ["register", "login"])) {
            $controller = "SecurityController";
            $action = 'login';
        }
        
        
        $object = new $controller;
        $action = $action ?: "index";
    
        $object->$action();
    }
}