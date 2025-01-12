<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repositories/ComponentRepository.php';
require_once __DIR__ . '/../models/Component.php';
require_once __DIR__ . '/../utilities/Decoder.php';

class BrowseController extends AppController
{
    private static ?BrowseController $instance = null;
    private ComponentRepository $componentRepository;

    private function __construct()
    {
        $this->componentRepository = ComponentRepository::getInstance();
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
            $search = $_GET['search'] ?? '';
            $sorting = $_GET['sorting'] ?? 'Newest';
            $filters = $_GET['filters'] ?? ['Buttons', 'Inputs', 'Checkboxes', 'Radio buttons'];
            if (!is_array($filters)) {
                $filters = [$filters];
            }
            $components = $this->componentRepository->getComponents($sorting, $filters, $search);
            $userSession = Decoder::decodeUserSession();
            if($userSession) {
                foreach ($components as $component) {
                    $component->setLiked($this->componentRepository->isLikedComponent($component->getId(), $userSession->getId()));
                }
            }
            return $this->render('browse', ['components' => $components]);
        }
    }
}