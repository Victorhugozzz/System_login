<?php

namespace Victor\SystemLogin\Api\Middleware;

use Victor\SystemLogin\Api\Core\JWTHandler;
use Victor\SystemLogin\Api\Core\Response;

class JWTMiddleware
{
    public function handle()
    {
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $authorization = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authorization || stripos($authorization, 'Bearer ') !== 0) {
            Response::json(['error' => 'Token de autorizacao ausente'], 401);
        }

        $token = trim(substr($authorization, 7));
        $jwt = new JWTHandler();
        $decoded = $jwt->validate($token);

        if (!$decoded || !isset($decoded->data)) {
            Response::json(['error' => 'Token de autorizacao invalido'], 401);
        }

        return $decoded->data;
    }
}
