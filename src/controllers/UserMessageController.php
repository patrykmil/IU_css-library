<?php

require_once "src/controllers/AppController.php";
require_once __DIR__ . '/../repositories/ComponentRepository.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../models/Component.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utilities/Decoder.php';
class UserMessageController extends AppController
{
    private static ?UserMessageController $instance = null;
    private ComponentRepository $componentRepository;
    private UserRepository $userRepository;

    private function __construct()
    {
        $this->componentRepository = ComponentRepository::getInstance();
        $this->userRepository = UserRepository::getInstance();
    }

    public static function getInstance(): UserMessageController
    {
        if (self::$instance == null) {
            self::$instance = new UserMessageController();
        }
        return self::$instance;
    }

    public function bannedComponents(): void
    {
        if ($this->isGet()) {
            $user = Decoder::decodeUserSession();
            if (!$user) {
                header('Location: /login');
            }
            $deleted = $this->componentRepository->getDeletedComponents($user->getId());
            $this->render('messages', ['deleted' => $deleted]);
        }
    }
}