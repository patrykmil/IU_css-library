<?php
require_once 'AppController.php';

class ComponentController extends AppController
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance()
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

        $this->render("component", ['component' => $component]);
    }
}
