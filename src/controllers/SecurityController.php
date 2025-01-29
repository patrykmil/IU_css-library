<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utilities/Validator.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class SecurityController extends AppController
{
    private static ?SecurityController $instance = null;
    private UserRepository $repository;

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

    public function login(): void
    {
        if ($this->isGet()) {
            $this->render("login");
            return;
        }
        if ($this->isPost()) {
            $email = $_POST['email-input'];
            $password = $_POST['password-input'];

            $email = Validator::verifyEmail($email);
            if (!$email) {
                $this->render('login', ['message' => 'Invalid email!!!']);
                return;
            }
            $password = Validator::verifyPassword($password);
            if (!$password) {
                $this->render('login', ['message' => 'Invalid password!!!']);
                return;
            }

            $user = $this->repository->getUserByEmail($email);
            if ($user == null) {
                $this->render('login', ['message' => 'Wrong email!!!']);
                return;
            }
            if (!password_verify($password, $user->getPassword())) {
                $this->render('login', ['message' => 'Wrong password!!!']);
                return;
            }

            $cookieValue = $this->repository->addUserSession($user->getId());
            setcookie('user_session', $cookieValue, time() + (60 * 60 * 24 * 30), "/", "", true, true);
            header("Location: /start");
        }
    }

    public function logout(): void
    {
        if ($this->repository->deleteUserSession($_COOKIE['user_session'])) {
            setcookie('user_session', '', time() - 3600, "/");
            $previousPage = $_SERVER['HTTP_REFERER'] ?? '/';
            header("Location: $previousPage");
        }
    }

    public function register(): void
    {
        if ($this->isGet()) {
            $this->render("register");
            return;
        }
        if ($this->isPost()) {
            $email = $_POST['email-input'];
            $nickname = $_POST['nickname-input'];
            $password = $_POST['password-input'];

            $email = Validator::verifyEmail($email);
            if (!$email) {
                $this->render('register', ['message' => 'Invalid email!!!']);
                return;
            }

            $password = Validator::verifyPassword($password);
            if (!$password) {
                $this->render('register', ['message' => 'Invalid password!!!']);
                return;
            }

            $nickname = Validator::verifyNickname($nickname);
            if (!$nickname) {
                $this->render('register', ['message' => 'Invalid nickname!!!']);
                return;
            }

            $user = new User($nickname);
            $user->setEmail($email);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

            if ($this->repository->addUser($user)) {
                $this->render('login', ['message' => 'Successfully registered!!!']);
                return;
            }
            $this->render('register', ['message' => 'User with this email already exists!!!']);
        }
    }
}