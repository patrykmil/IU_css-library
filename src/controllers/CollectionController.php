<?php

require_once "src/controllers/AppController.php";
require_once __DIR__ . '/../repositories/ComponentRepository.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../models/Component.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utilities/Decoder.php';

class CollectionController extends AppController
{
    private static ?CollectionController $instance = null;
    private ComponentRepository $componentRepository;
    private UserRepository $userRepository;

    private function __construct()
    {
        $this->componentRepository = ComponentRepository::getInstance();
        $this->userRepository = UserRepository::getInstance();
    }

    public static function getInstance(): CollectionController
    {
        if (self::$instance == null) {
            self::$instance = new CollectionController();
        }
        return self::$instance;
    }

    public function collection(string $nickname)
    {
        if ($this->isGet()) {
            $user = $this->userRepository->getUserByName($nickname);
            $liked = $this->componentRepository->getLikedComponents($user->getId());
            $owned = $this->componentRepository->getOwnedComponents($user->getId());
            $userSession = Decoder::decodeUserSession();
            if ($userSession) {
                foreach ($liked as $component) {
                    $component->setLiked($this->componentRepository->isLikedComponent($component->getId(), $userSession->getId()));
                }
                if ($user->getId() !== $userSession->getId()) {
                    foreach ($owned as $set) {
                        foreach ($set['components'] as $component) {
                            $component->setLiked($this->componentRepository->isLikedComponent($component->getId(), $userSession->getId()));
                        }
                    }
                }
            }
            return $this->render('collection', ['user' => $user, 'liked' => $liked, 'owned' => $owned]);
        }
    }

    public function deleteComponent()
    {
        if ($this->isPost()) {
            $user = Decoder::decodeUserSession();
            if ($user) {
                $data = json_decode(file_get_contents('php://input'), true);
                $componentID = $data['componentID'];
                $this->componentRepository->getComponentById($componentID);
                if ($this->componentRepository->getComponentById($componentID)->getAuthor()->getId() === $user->getId()) {
                    $this->componentRepository->deleteComponent($componentID);
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            echo json_encode(['success' => false]);
        }
    }
}