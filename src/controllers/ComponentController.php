<?php
require_once 'AppController.php';
require_once 'src/repositories/ComponentRepository.php';
require_once __DIR__ . '/../utilities/Decoder.php';

class ComponentController extends AppController
{
    private static ?ComponentController $instance = null;
    private ComponentRepository $componentRepository;

    private function __construct()
    {
        $this->componentRepository = ComponentRepository::getInstance();
    }

    public static function getInstance(): ComponentController
    {
        if (self::$instance == null) {
            self::$instance = new ComponentController();
        }
        return self::$instance;
    }

    public function component(int $id): void
    {
        if ($this->isGet()) {
            require_once 'src/models/Component.php';
            require_once 'src/models/User.php';
            require_once 'src/repositories/UserRepository.php';

            $component = $this->componentRepository->getComponentById($id);
            if (!$component) {
                require_once 'src/controllers/ErrorController.php';
                ErrorController::getInstance()->error404();
                return;
            }
            $userSession = Decoder::decodeUserSession();
            if ($userSession) {
                $component->setLiked($this->componentRepository->isLikedComponent($component->getId(), $userSession->getId()));
            }
            $this->render("component", ['component' => $component, 'user' => $userSession]);
        }
    }

    public function toggleLike(): void
    {
        $userSession = Decoder::decodeUserSession();

        $data = json_decode(file_get_contents('php://input'), true);
        $componentID = $data['componentID'];
        $userID = $userSession->getId();

        if ($this->componentRepository->isLikedComponent($componentID, $userID)) {
            $this->componentRepository->unlikeComponent($componentID, $userID);
            echo json_encode(['liked' => false]);
        } else {
            $this->componentRepository->likeComponent($componentID, $userID);
            echo json_encode(['liked' => true]);
        }
    }

    public function adminDeleteComponent(): void
    {
        $userSession = Decoder::decodeUserSession();
        if (!$userSession || !$userSession->isAdministrator()) {
            http_response_code(403);
            echo json_encode(['success' => false]);
            return;
        }
        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $messageID = $data['messageID'];
            $componentID = $data['componentID'];
            $this->componentRepository->adminDeleteComponent($componentID, $messageID);
            echo json_encode(['success' => true]);
        }
    }
}