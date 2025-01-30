<?php
require_once 'AppController.php';
require_once __DIR__ . '/../utilities/Decoder.php';
require_once __DIR__ . '/../repositories/ComponentRepository.php';
require_once __DIR__ . '/../repositories/DefaultRepository.php';

class CreateController extends AppController
{
    private static ?CreateController $instance = null;
    private ComponentRepository $componentRepository;
    private DefaultRepository $defaultRepository;

    private function __construct()
    {
        $this->componentRepository = ComponentRepository::getInstance();
        $this->defaultRepository = DefaultRepository::getInstance();
    }

    public static function getInstance(): CreateController
    {
        if (self::$instance == null) {
            self::$instance = new CreateController();
        }
        return self::$instance;
    }

    public function create(): void
    {
        $userSession = Decoder::decodeUserSession();
        if ($this->isGet()) {
            if (!$userSession) {
                $this->render('login', ['message' => 'You need to log in first!']);
                return;
            }
            $types = $this->defaultRepository->getTypes();
            $sets = $this->defaultRepository->getUserSets($userSession->getId());
            $tags = $this->defaultRepository->getTagNames();
            $this->render('create', ['userID' => $userSession->getId(), 'types' => $types, 'sets' => $sets, 'tags' => $tags]);
            return;
        }

        if ($this->isPost()) {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $set = $_POST['set'];
            $color = $_POST['color'];
            $tags = json_decode($_POST['tags'], true);
            $userID = $userSession->getId();
            $css = $_POST['css'];
            $html = $_POST['html'];
            try {
                $componentID = $this->componentRepository->addComponent($name, $type, $set, $color, $tags, $userID, $css, $html);
            } catch (Exception $e) {
                echo json_encode(['error' => 'Unable to create component']);
                return;
            }
            header('Content-Type: application/json');
            echo json_encode(['url' => "/component/{$componentID}"]);
        }
    }

    public function createSet(): void
    {
        $userSession = Decoder::decodeUserSession();
        if (!$userSession) {
            http_response_code(401);
            echo json_encode(['error' => 'An error occurred while adding a set.']);
            return;
        }
        if ($this->isPost()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $setName = $data['setName'];
            $sets = $this->defaultRepository->addSet($userSession->getId(), $setName);
            echo json_encode($sets);
        }
    }
}