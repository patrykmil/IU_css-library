<?php
require_once 'AppController.php';

class ComponentController extends AppController
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ComponentController();
        }
        return self::$instance;
    }

    public function component()
    {
        $this->render("component");
    }
}
