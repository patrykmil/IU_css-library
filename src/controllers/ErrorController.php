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

  public function error404(): null
  {
    return $this->render("error", ["code" => 404, "message" => "Page not found"]);
  }

  public function error500(): null
  {
    return $this->render("error", ["code" => 500, "message" => "Internal server error"]);
  }

}
