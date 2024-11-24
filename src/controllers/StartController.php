<?php
require_once 'AppController.php';

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
    $this->render("start", ['name' => "Patryk"]);
  }
}
