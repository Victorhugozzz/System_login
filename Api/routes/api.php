<?php

require_once __DIR__ . '/../../bootstrap.php';

use Victor\SystemLogin\Api\Controllers\AuthController;
use Victor\SystemLogin\Api\Core\Response;

$auth = new AuthController();

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
$route = $requestPath;

if ($scriptDir !== '' && $scriptDir !== '.' && str_starts_with($route, $scriptDir)) {
    $route = substr($route, strlen($scriptDir));
}

if (str_starts_with($route, '/index.php')) {
    $route = substr($route, strlen('/index.php'));
}

$route = '/' . ltrim($route, '/');
$method = $_SERVER['REQUEST_METHOD'];

if ($route === '/register' && $method === 'POST') {
    $auth->register();
    return;
}

if ($route === '/login' && $method === 'POST') {
    $auth->login();
    return;
}

Response::json(['error' => 'Rota nao encontrada'], 404);
