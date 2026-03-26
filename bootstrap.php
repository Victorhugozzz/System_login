<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

spl_autoload_register(function ($class) {
    $prefix = 'Firebase\\JWT\\';

    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = __DIR__ . '/../vendor/firebase/php-jwt/src/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});
