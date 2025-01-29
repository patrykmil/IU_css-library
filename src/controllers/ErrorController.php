<?php
require_once 'AppController.php';

class ErrorController extends AppController
{
    private static ?ErrorController $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): ErrorController
    {
        if (self::$instance == null) {
            self::$instance = new ErrorController();
        }
        return self::$instance;
    }

    public function error401(): void
    {
        if ($this->isGet()) {
            $this->render("error", ["code" => 401, "message" => "Unauthorized Error"]);
        }
    }

    public function error404(): void
    {
        if ($this->isGet()) {
            $this->render("error", ["code" => 404, "message" => "Page not found"]);
        }
    }

    public function error500(): void
    {
        if ($this->isGet()) {
            $this->render("error", ["code" => 500, "message" => "Internal server error"]);
        }
    }

}
