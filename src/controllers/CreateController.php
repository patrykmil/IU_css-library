<?php
require_once 'AppController.php';

class CreateController extends AppController
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CreateController();
        }
        return self::$instance;
    }

    public function component()
    {
        return $this->render("create");
    }
}
