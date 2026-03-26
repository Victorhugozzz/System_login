<?php 

namespace Victor\SystemLogin\Core;

class Session {

    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            ]);
            session_start();
        }
    }

    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get($key) {
        self::start();
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key) {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy() {
        if (session_status() !== PHP_SESSION_NONE) {
            session_unset();
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
            }
            session_destroy();
        }
    }

    public static function regenerate() {
        self::start();
        session_regenerate_id(true);
    }

    public static function setFlash($key, $message) {
        self::start();
        $_SESSION['flash'][$key] = $message;
    }

    public static function getFlash($key) {
        self::start();
        
        if (!isset($_SESSION['flash'][$key])) {
            return null;
        }

        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);

        return $message;
    }
}
