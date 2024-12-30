<?php
require_once 'Repository.php';
class DefaultRepository extends Repository
{
    private static ?DefaultRepository $instance = null;

    public static function getInstance(): DefaultRepository
    {
        if (self::$instance == null) {
            self::$instance = new DefaultRepository();
        }
        return self::$instance;
    }

    public function getTagNames(): array
    {
        $query = 'SELECT name FROM public."Tag"';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getTypes(): array
    {
        $query = 'SELECT name FROM public."Type"';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getUserSets($authorID): array
    {
        $query = 'SELECT name FROM public."Set" WHERE ownerid = :id';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':id', $authorID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}