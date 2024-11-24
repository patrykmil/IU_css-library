<?php
require_once 'AppController.php';

class SecurityController extends AppController
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SecurityController();
        }
        return self::$instance;
    }

    public function login()
    {
        $this->render("login");
    }
}
