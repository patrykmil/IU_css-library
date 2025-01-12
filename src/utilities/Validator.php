<?php

class Validator
{
    public static function verifyEmail(string $email): ?string
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function verifyPassword(string $password): ?string
    {
        $password = self::check_input($password);
        if (!preg_match('/^[A-Za-z0-9-?!%&$_]*$/', $password) || strlen($password) < 8) {
            return false;
        }
        return $password;
    }

    public static function verifyNickname(string $nickname): ?string
    {
        $nickname = self::check_input($nickname);
        if (!preg_match('/^[A-Za-z0-9-?_]*$/', $nickname) || strlen($nickname) < 3) {
            return false;
        }
        return $nickname;
    }

    public static function check_input($data): ?string
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}