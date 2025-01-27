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
        $query = 'SELECT * FROM public."UserDetailsView"';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        $userObjects = [];
        foreach ($users as $user) {
            $userObject = new User($user['nickname']);
            $userObject->setEmail($user['email']);
            $userObject->setId($user['userid']);
            $userObject->setAvatar($user['avatarpath']);
            $userObjects[] = $userObject;
        }
        return $userObjects;
    }

    public function getUserById(int $id): ?User
    {
        $query = 'SELECT * FROM public."UserDetailsView" WHERE userid = :id';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        if (!$user) {
            return null;
        }
        $userObject = new User($user['nickname']);
        $userObject->setEmail($user['email']);
        $userObject->setId($user['userid']);
        $userObject->setAvatar($user['avatarpath']);
        return $userObject;
    }

    public function getUserByEmail(string $email): ?User
    {
        $query = 'SELECT * FROM public."User" WHERE email = :email';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
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
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
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
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':avatarId', $avatarId, PDO::PARAM_INT);
        $stmt->execute();
        $avatar = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        if (!$avatar) {
            return null;
        }
        return $avatar['avatarpath'];
    }

    public function addUser(User $user): bool
    {
        $query = 'SELECT add_user(:email, :nickname, :passwordhash)';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $email = $user->getEmail();
        $nickname = $user->getNickname();
        $password = $user->getPassword();
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nickname', $nickname);
        $stmt->bindParam(':passwordhash', $password);
        $stmt->execute();
        $success = $stmt->fetchColumn();
        $this->database->disconnect($conn);
        return $success;
    }

    public function addUserSession(int $userId): string
    {
        $query = 'SELECT add_user_session(:userID)';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $token = $stmt->fetchColumn();
        $this->database->disconnect($conn);
        return $token ?: '';
    }

    public function deleteUserSession(string $token): bool
    {
        $query = 'DELETE FROM public."UserSession" WHERE token = :token';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $success = $stmt->execute();
        $this->database->disconnect($conn);
        return $success;
    }

    public function getUserBySession(string $token): ?User
    {
        $query = 'SELECT * FROM public."UserSession" WHERE token = :token';
        $conn = $this->database->connect();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->database->disconnect($conn);
        if (!$session) {
            return null;
        }
        return $this->getUserById($session['userid']);
    }
}