<?php
require_once 'AppController.php';

class SecurityController extends AppController
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SecurityController();
        }
        return self::$instance;
    }

    public function login()
    {
        if ($this->isGet()) {
            return $this->render("login");
        }

        $login = $_POST['login_input'];
        $password = $_POST['password_input'];

        $this->render('component', ['login' => $login, 'password' => $password]);
    }
}