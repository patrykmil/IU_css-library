<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repositories/ComponentRepository.php';
class BrowseController extends AppController
{
    private static ?BrowseController $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): BrowseController
    {
        if (self::$instance == null) {
            self::$instance = new BrowseController();
        }
        return self::$instance;
    }

    public function browse()
    {
        if ($this->isGet()) {
            $repo = ComponentRepository::getInstance();
            $all = $repo->getComponents();
            return $this->render('browse', ['components' => $all]);
        }
    }
}