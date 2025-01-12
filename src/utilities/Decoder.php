<?php
require_once __DIR__ . '/../repositories/UserRepository.php';
class Decoder
{
    public static function decodeUserSession(): ?User
    {
        if(!isset($_COOKIE['user_session'])) {
            return null;
        }
        $userSession = $_COOKIE['user_session'];
        $user = UserRepository::getInstance()->getUserBySession($userSession);
        if($user == null) {
            return null;
        }
        return $user;
    }
}