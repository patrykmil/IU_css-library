<?php
require_once 'AppController.php';

class BrowseController extends AppController
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new BrowseController();
        }
        return self::$instance;
    }

    public function browse()
    {
        if ($this->isGet()) {
            return $this->render('browse');
        }
    }
}