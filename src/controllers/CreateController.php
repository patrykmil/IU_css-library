<?php
require_once 'AppController.php';
require_once __DIR__ . '/../utilities/Decoder.php';

class CreateController extends AppController
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CreateController();
        }
        return self::$instance;
    }

    public function create()
    {
        $sessionInfo = Decoder::decodeUserSession();
        if ($this->isGet()) {
            if (!$sessionInfo) {
                return $this->render('login', ['message' => 'You need to log in first!']);
            }
            return $this->render('create', ['userID' => $sessionInfo['id']]);
        }
    }
}
