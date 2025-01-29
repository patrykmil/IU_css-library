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
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $names = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $this->database->disconnect($conn);
        return $names;
    }

    public function getTypes(): array
    {
        $query = 'SELECT name FROM public."Type"';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $types = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $this->database->disconnect($conn);
        return $types;
    }

    public function getUserSets(int $authorID): array
    {
        $query = 'SELECT name FROM public."Set" WHERE ownerid = :id';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $authorID, PDO::PARAM_INT);
        $stmt->execute();
        $sets = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $this->database->disconnect($conn);
        return $sets;
    }

    public function addSet(int $authorID, int $setName): array
    {
        $query = 'INSERT INTO public."Set" (name, ownerid) VALUES (:name, :ownerid)';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $setName);
        $stmt->bindParam(':ownerid', $authorID, PDO::PARAM_INT);
        $stmt->execute();
        $sets = $this->getUserSets($authorID);
        $this->database->disconnect($conn);
        return $sets;
    }
}