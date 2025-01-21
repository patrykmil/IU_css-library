<?php

require_once 'AppController.php';
require_once __DIR__.'/../utilities/Decoder.php';
class StartController extends AppController
{
  private static ?StartController $instance = null;

  private function __construct() {}

  public static function getInstance(): StartController
  {
    if (self::$instance == null) {
      self::$instance = new StartController();
    }
    return self::$instance;
  }

  public function start()
  {
      $userSession = Decoder::decodeUserSession();
      if ($this->isGet()) {
          return $this->render("start", ['user' => $userSession]);
      }
  }
}
