<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repositories/ComponentRepository.php';
require_once __DIR__ . '/../models/Component.php';
require_once __DIR__ . '/../utilities/Decoder.php';
class BrowseController extends AppController
{
    private static ?BrowseController $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): BrowseController
    {
        if (self::$instance == null) {
            self::$instance = new BrowseController();
        }
        return self::$instance;
    }

    public function browse()
    {
        if ($this->isGet()) {
            $repo = ComponentRepository::getInstance();
            $search = $_GET['search'] ?? '';
            $sorting = $_GET['sorting'] ?? 'Newest';
            $filters = $_GET['filters'] ?? ['Buttons', 'Inputs', 'Checkboxes', 'Radio buttons'];
            if (!is_array($filters)) {
                $filters = [$filters];
            }
            $components = $repo->getComponents($sorting, $filters, $search);
            $sessionInfo = Decoder::decodeUserSession();
            if($sessionInfo) {
                foreach ($components as $component) {
                    $component->setLiked($repo->isLikedComponent($component->getId(), $sessionInfo['id']));
                }
            }
            return $this->render('browse', ['components' => $components]);
        }
    }
}