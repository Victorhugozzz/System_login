<?php

namespace Victor\SystemLogin\Api\Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
    private array $config;

    public function __construct(?array $config = null)
    {
        $this->config = $config ?? require __DIR__ . '/../config/jwt.php';
    }

    public function generate(array $user): string
    {
        if (empty($this->config['key'])) {
            throw new \RuntimeException('Chave JWT nao configurada.');
        }

        $payload = [
            'iss' => $this->config['issuer'],
            'aud' => $this->config['audience'],
            'iat' => time(),
            'exp' => time() + $this->config['expires'],
            'data' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'] ?? 'user',
            ],
        ];

        return JWT::encode($payload, $this->config['key'], 'HS256');
    }

    public function validate(string $token): ?object
    {
        if ($token === '' || empty($this->config['key'])) {
            return null;
        }

        try {
            return JWT::decode($token, new Key($this->config['key'], 'HS256'));
        } catch (\Throwable $e) {
            return null;
        }
    }
}