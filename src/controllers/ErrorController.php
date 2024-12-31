<?php
require_once 'AppController.php';

class ErrorController extends AppController
{
  private static ?ErrorController $instance = null;

  private function __construct() {}

  public static function getInstance(): ErrorController
  {
    if (self::$instance == null) {
      self::$instance = new ErrorController();
    }
    return self::$instance;
  }

  public function error404()
  {
    return $this->render("errors/e404");
  }

  public function error500()
  {
    return $this->render("errors/e500");
  }
}
