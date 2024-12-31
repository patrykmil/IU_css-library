<?php
require_once 'AppController.php';
require_once __DIR__ . '/../utilities/Decoder.php';
require_once __DIR__ . '/../repositories/ComponentRepository.php';
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
            return $this->render('create', ['userID' => $sessionInfo['id']]);
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
}
