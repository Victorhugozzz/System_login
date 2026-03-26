<?php

namespace Victor\SystemLogin\Api\Core;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
