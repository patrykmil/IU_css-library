<?php

class Decoder
{
    public static function decodeUserSession()
    {
        if (isset($_COOKIE['user_session'])) {
            return json_decode(base64_decode($_COOKIE['user_session']), true);
        }
        return null;
    }
}