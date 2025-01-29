<?php

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
        $this->username = getenv('POSTGRES_USER');
        $this->password = getenv('POSTGRES_PASSWORD');
        $this->host = getenv('HOST');
        $this->database = getenv('POSTGRES_DB');
        $this->port = getenv('PORT');
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
