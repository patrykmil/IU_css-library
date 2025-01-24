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
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userObjects = [];
        foreach ($users as $user) {
            $userObject = new User($user['nickname']);
            $userObject->setEmail($user['email']);
            $userObject->setId($user['userid']);
            $avatar = $this->getUserAvatar($user['avatarid']);
            $userObject->setAvatar($avatar);
            $userObjects[] = $userObject;
        }
        return $userObjects;
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
        $stmt->bindParam(':email', $email);
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

    public function getUserByName(string $name): ?User
    {
        $query = 'SELECT * FROM public."User" WHERE nickname = :name';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':name', $name);
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
        try {
            $avatarID = random_int(1, 9);
        } catch (Exception) {
            $avatarID = 1;
        }
        return $stmt->execute([
            $user->getEmail(),
            $user->getNickname(),
            $user->getPassword(),
            $avatarID
        ]);
    }

    public function addUserSession(int $userId): string
    {
        do {
            try {
                $token = bin2hex(random_bytes(16));
            } catch (Exception) {
                return '';
            }
            $query = 'SELECT COUNT(*) FROM public."UserSession" WHERE token = :token';
            $stmt = $this->database->connect()->prepare($query);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $count = $stmt->fetchColumn();
        } while ($count > 0);

        $query = 'INSERT INTO public."UserSession" (token, userID, expiresAt) VALUES (:token, :userID, CURRENT_TIMESTAMP + INTERVAL \'30 days\')';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $token;
        }
        return '';
    }

    public function deleteUserSession(string $token): bool
    {
        $query = 'DELETE FROM public."UserSession" WHERE token = :token';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':token', $token);
        return $stmt->execute();
    }

    public function getUserBySession(string $token): ?User
    {
        $query = 'SELECT * FROM public."UserSession" WHERE token = :token';
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$session) {
            return null;
        }
        return $this->getUserById($session['userid']);
    }
}