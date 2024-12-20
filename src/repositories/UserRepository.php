<?php

require_once 'src/models/User.php';
require_once 'Repository.php';
class UserRepository extends Repository
{
    public function getUsers(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."User"');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

}