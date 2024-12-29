<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../validation/Validator.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

use validation\Validator;

class SecurityController extends AppController
{
    private static ?SecurityController $instance = null;
    private Repository $repository;

    private function __construct()
    {
        $this->repository = UserRepository::getInstance();
    }

    public static function getInstance(): ?SecurityController
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

        $email = Validator::verifyEmail($email);
        if (!$email) {
            return $this->render('login', ['message' => 'Invalid email!!!']);
        }
        $password = Validator::verifyPassword($password);
        if (!$password) {
            return $this->render('login', ['message' => 'Invalid password!!!']);
        }

        $user = $this->repository->getUserByEmail($email);
        if ($user == null) {
            return $this->render('login', ['message' => 'Wrong email!!!']);
        }
        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['message' => 'Wrong password!!!']);
        }

        $cookieValue = base64_encode(json_encode(['email' => $user->getEmail(), 'nickname' => $user->getNickname(), 'admin' => $user->isAdminstrator(), 'avatar' => $user->getAvatar()]));
        setcookie('user_session', $cookieValue, time() + (60 * 60 * 24 * 30), "/", "", true, true);
        header("Location: /browse");
        exit();
    }

    public function logout()
    {
        setcookie('user_session', '', time() - 3600, "/");
        $previousPage = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $previousPage");
        exit();
    }

    public function register()
    {
        if ($this->isGet()) {
            return $this->render("register");
        }

        $email = $_POST['email_input'];
        $nickname = $_POST['nickname_input'];
        $password = $_POST['password_input'];

        $email = Validator::verifyEmail($email);
        if (!$email) {
            return $this->render('register', ['message' => 'Invalid email!!!']);
        }

        $password = Validator::verifyPassword($password);
        if (!$password) {
            return $this->render('register', ['message' => 'Invalid password!!!']);
        }

        $nickname = Validator::verifyNickname($nickname);
        if (!$nickname) {
            return $this->render('register', ['message' => 'Invalid nickname!!!']);
        }

        $user = new User($nickname);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        if ($this->repository->addUser($user)) {
            return $this->render('login', ['message' => 'Successfully registered!!!']);
        }
        return $this->render('register', ['message' => 'User with this email already exists!!!']);
    }
}