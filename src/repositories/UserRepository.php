<?php

require_once 'src/models/User.php';
require_once 'Repository.php';

class UserRepository extends Repository
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function getUsers(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."User"');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $id): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."User" WHERE userid = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }
        return new User(
            $user['email'],
            $user['nickname'],
            $user['password'],
            $user['id']
        );
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."User" WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }
        return new User(
            $user['email'],
            $user['nickname'],
            $user['passwordhash'],
            $user['avatarid']
        );
    }

    public function addUser(User $user): bool
    {
        if ($this->getUserByEmail($user->getEmail())) {
            return false;
        }
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."User" (email, nickname, passwordhash, avatarid)
            VALUES (?, ?, ?, ?)
        ');
        return $stmt->execute([
            $user->getEmail(),
            $user->getNickname(),
            $user->getPassword(),
            random_int(0,5)
        ]);
    }
}