<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
class SecurityController extends AppController
{
    private static $instance = null;
    private array $users = [];
    private function __construct()
    {
        $this->users[] = new User('p@p', 'p', password_hash('p', PASSWORD_BCRYPT));
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
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email && password_verify($password, $user->getPassword())) {
                return $this->render('component', ['user' => $user]);
            }
        }
        return $this->render('login', ['message' => 'Wrong email or password!!!']);
    }

    public function register()
    {
        if ($this->isGet()) {
            return $this->render("register");
        }

        $email = $_POST['email_input'];
        $nickname = $_POST['nickname_input'];
        $password = $_POST['password_input'];

        $user = new User($email, $nickname, password_hash($password, PASSWORD_BCRYPT));
        $this->users[] = $user;
        return $this->render('login', ['message' => 'Successfully registered!!!']);
    }
}