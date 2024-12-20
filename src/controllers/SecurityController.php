<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../validation/Validator.php';

use validation\Validator;

class SecurityController extends AppController
{
    private static $instance = null;
    private array $users = [];

    private function __construct()
    {
        $this->users[] = new User('iuadmin@iu.iu', 'admin', password_hash('adminadmin', PASSWORD_BCRYPT));
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

        $email = $_POST['email_input'];
        $password = $_POST['password_input'];

        if (!Validator::verifyEmail($email)) {
            return $this->render('login', ['message' => 'Invalid email!!!']);
        }
        if (!Validator::verifyPassword($password)) {
            return $this->render('login', ['message' => 'Invalid password!!!']);
        }
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email && password_verify($password, $user->getPassword())) {
                return $this->render('component', ['user' => $user]);
            }
        }
        header('Location: /login');
        return $this->render('login', ['message' => 'Invalid email or password!!!']);
    }

    public function register()
    {
        if ($this->isGet()) {
            return $this->render("register");
        }
        $email = $_POST['email_input'];
        $nickname = $_POST['nickname_input'];
        $password = $_POST['password_input'];

        if (!Validator::verifyEmail($email)) {
            return $this->render('register', ['message' => 'Invalid email!!!']);
        }
        if (!Validator::verifyPassword($password)) {
            return $this->render('register', ['message' => 'Invalid password!!!']);
        }
        if (!Validator::verifyNickname($nickname)) {
            return $this->render('register', ['message' => 'Invalid nickname!!!']);
        }

        $user = new User($email, $nickname, password_hash($password, PASSWORD_BCRYPT));
        $this->users[] = $user;
        return $this->render('login', ['message' => 'Successfully registered!!!']);
    }
}