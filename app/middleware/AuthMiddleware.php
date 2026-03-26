<?php

namespace Victor\SystemLogin\Middleware;

use Victor\SystemLogin\Core\Session;

class AuthMiddleware
{
    public static function check()
    {
        Session::start();

        if (!Session::get('user')) {
            header('Location: login.php');
            exit;
        }
    }

    public static function isAdmin()
    {
        Session::start();

        $user = Session::get('user');
        $role = $user['ROLE'] ?? $user['role'] ?? null;

        if (!$user || strtolower((string) $role) !== 'admin') {
            die('Acesso negado');
        }
    }
}
