<?php
require_once 'AppController.php';

class E404Controller extends AppController
{
  private static $instance = null;

  private function __construct() {}

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new E404Controller();
    }
    return self::$instance;
  }

  public function e404()
  {
    $this->render("errors/e404");
  }
}
