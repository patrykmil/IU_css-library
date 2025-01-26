<?php

require_once "config.php";

class DatabaseConnector
{
    private static ?DatabaseConnector $instance = null;
    public static function getInstance(): DatabaseConnector
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnector();
        }
        return self::$instance;
    }
    private string $username;
    private string $password;
    private string $host;
    private string $database;
    private int $port;

    private function __construct()
    {
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        $this->database = DATABASE;
        $this->port = PORT;
    }


    public function connect(): PDO
    {
        try {
            $conn = new PDO(
                "pgsql:host=$this->host;port=$this->port;dbname=$this->database",
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            $errorController = ErrorController::getInstance();
            $errorController->error500();
        }
        exit();
    }

    public function disconnect(PDO &$conn): void
    {
        $conn = null;
    }


}
