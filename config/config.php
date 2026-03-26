<?php

$env = parse_ini_file(__DIR__ . '/../.env');

if ($env === false) {
    throw new RuntimeException('Arquivo .env nao encontrado ou invalido.');
}

foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

defined('DB_HOST') || define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
defined('DB_NAME') || define('DB_NAME', $env['DB_NAME'] ?? '');
defined('DB_USER') || define('DB_USER', $env['DB_USER'] ?? 'root');
defined('DB_PASS') || define('DB_PASS', $env['DB_PASS'] ?? '');
