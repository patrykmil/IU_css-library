<?php
require_once 'AppController.php';
require_once 'src/repositories/ComponentRepository.php';
require_once __DIR__ . '/../utilities/Decoder.php';

class ComponentController extends AppController
{
    private static ?ComponentController $instance = null;

    private function __construct() {}

    public static function getInstance(): ComponentController
    {
        if (self::$instance == null) {
            self::$instance = new ComponentController();
        }
        return self::$instance;
    }

    public function component(int $id)
    {
        require_once 'src/models/Component.php';
        require_once 'src/models/User.php';
        require_once 'src/repositories/ComponentRepository.php';
        require_once 'src/repositories/UserRepository.php';

        $repository = ComponentRepository::getInstance();
        $component = $repository->getComponentById($id);
        $sessionInfo = Decoder::decodeUserSession();
        if($sessionInfo) {
            $component->setLiked($repository->isLikedComponent($component->getId(), $sessionInfo['id']));
        }
        $this->render("component", ['component' => $component]);
    }

    public function toggleLike(): void
    {
        $sessionInfo = Decoder::decodeUserSession();

        $data = json_decode(file_get_contents('php://input'), true);
        $componentID = $data['componentID'];
        $userID = $sessionInfo['id'];

        $componentRepository = ComponentRepository::getInstance();
        if ($componentRepository->isLikedComponent($componentID, $userID)) {
            $componentRepository->unlikeComponent($componentID, $userID);
            echo json_encode(['liked' => false]);
        } else {
            $componentRepository->likeComponent($componentID, $userID);
            echo json_encode(['liked' => true]);
        }
    }
}
