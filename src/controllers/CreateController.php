<?php
require_once 'AppController.php';
require_once __DIR__ . '/../utilities/Decoder.php';
require_once __DIR__ . '/../repositories/ComponentRepository.php';
require_once __DIR__ . '/../repositories/DefaultRepository.php';
class CreateController extends AppController
{
    private static ?CreateController $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CreateController();
        }
        return self::$instance;
    }

    public function create()
    {
        $sessionInfo = Decoder::decodeUserSession();
        if ($this->isGet()) {
            if (!$sessionInfo) {
                return $this->render('login', ['message' => 'You need to log in first!']);
            }
            $repo = DefaultRepository::getInstance();
            $types = $repo->getTypes();
            $sets = $repo->getUserSets($sessionInfo['id']);
            $tags = $repo->getTagNames();
            return $this->render('create', ['userID' => $sessionInfo['id'], 'types' => $types, 'sets' => $sets, 'tags' => $tags]);
        }

        if ($this->isPost()) {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $set = $_POST['set'];
            $color = $_POST['color'];
            $tags = json_decode($_POST['tags'], true);
            $userID = $sessionInfo['id'];
            $css = $_POST['css'];
            $html = $_POST['html'];
            $repo = ComponentRepository::getInstance();
            $repo->createComponent($name, $type, $set, $color, $tags, $userID, $css, $html);
            $this->render('create', ['userID' => $userID]);
        }
    }

    public function createSet()
    {
        $sessionInfo = Decoder::decodeUserSession();
        if (!$sessionInfo) {
            return ErrorController::getInstance()->error500();
//            zmienić na error 401
        }
        $setName = $_POST['setName'];
        $repo = DefaultRepository::getInstance();
        $sets = $repo->addSet(Decoder::decodeUserSession()['id'], $setName);
        echo json_encode($sets);
    }
}
