<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/UserRepository.php';
class StartController extends AppController
{
  private static $instance = null;

  private function __construct() {}

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new StartController();
    }
    return self::$instance;
  }

  public function start()
  {
      if ($this->isGet()) {
          $userRepository = new UserRepository();
          $users = $userRepository->getUsers();
          return $this->render("start", ['message' => sizeof($users)]);
      }
  }

    public function test()
    {
        if ($this->isGet()) {
            return $this->render("component_repository_test");
        }
    }
}
