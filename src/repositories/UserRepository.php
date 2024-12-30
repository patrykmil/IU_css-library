<?php

require_once 'src/models/User.php';
require_once 'Repository.php';

class UserRepository extends Repository
{
    private static ?UserRepository $instance = null;

    public static function getInstance(): UserRepository
    {
        if (self::$instance == null) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function getUsers(): array
    {
        $query = 'SELECT * FROM public."User"';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById(int $id): ?User
    {
        $query = 'SELECT * FROM public."User" WHERE userid = :id';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }
        $userObject = new User($user['nickname']);
        $userObject->setEmail($user['email']);
        $userObject->setId($user['userid']);
        $avatar = $this->getUserAvatar($user['avatarid']);
        $userObject->setAvatar($avatar);
        return $userObject;
    }

    public function getUserByEmail(string $email): ?User
    {
        $query = 'SELECT * FROM public."User" WHERE email = :email';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }
        $userObject = new User($user['nickname']);
        $userObject->setEmail($user['email']);
        $userObject->setId($user['userid']);
        $userObject->setPassword($user['passwordhash']);
        $avatar = $this->getUserAvatar($user['avatarid']);
        $userObject->setAvatar($avatar);
        return $userObject;
    }

    public function getUserAvatar(int $avatarId): ?string
    {
        $query = 'SELECT avatarpath FROM public."Avatar" WHERE avatarid = :avatarId';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':avatarId', $avatarId, PDO::PARAM_INT);
        $stmt->execute();
        $avatar = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$avatar) {
            return null;
        }
        return $avatar['avatarpath'];
    }

    public function addUser(User $user): bool
    {
        if ($this->getUserByEmail($user->getEmail())) {
            return false;
        }
        $query = 'INSERT INTO public."User" (email, nickname, passwordhash, avatarid) VALUES (?, ?, ?, ?)';
        $stmt = $this->database->connect()->prepare($query);
        return $stmt->execute([
            $user->getEmail(),
            $user->getNickname(),
            $user->getPassword(),
            random_int(1, 9)
        ]);
    }
}