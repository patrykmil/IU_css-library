<?php

namespace validation;

class Validator
{
    public static function verifyEmail(string $email): bool
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function verifyPassword(string $password): bool
    {
        $password = self::check_input($password);
        if (!preg_match('/^[A-Za-z0-9-?!%&$_]*$/', $password) || strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public static function verifyNickname(string $nickname): bool
    {
        $nickname = self::check_input($nickname);
        if (!preg_match('/^[A-Za-z0-9-?_]*$/', $nickname) || strlen($nickname) < 3) {
            return false;
        }
        return true;
    }

    private static function check_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}