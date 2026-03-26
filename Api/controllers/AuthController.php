<?php

namespace Victor\SystemLogin\Api\Controllers;

use Victor\SystemLogin\Api\Core\Response;
use Victor\SystemLogin\Api\Models\User;
use Victor\SystemLogin\Api\Core\JWTHandler;

class AuthController
{
    private function getRequestData()
    {
        $rawBody = file_get_contents('php://input');
        $contentType = $_SERVER['CONTENT_TYPE'] ?? $_SERVER['HTTP_CONTENT_TYPE'] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            $data = json_decode($rawBody, true);
            return is_array($data) ? $data : null;
        }

        if (!empty($_POST)) {
            return $_POST;
        }

        if ($rawBody !== '') {
            $data = json_decode($rawBody, true);
            if (is_array($data)) {
                return $data;
            }

            parse_str($rawBody, $formData);
            if (is_array($formData) && !empty($formData)) {
                return $formData;
            }
        }

        return null;
    }

    public function register()
    {
        $data = $this->getRequestData();

        if (!is_array($data)) {
            Response::json(['error' => 'Dados da requisicao invalidos'], 400);
        }

        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['senha'] ?? '';

        if ($username === '' || $email === '' || $password === '') {
            Response::json(['error' => 'Campos obrigatorios'], 400);
        }

        $userModel = new User();

        if ($userModel->findByEmail($email)) {
            Response::json(['error' => 'Email ja existe'], 400);
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $created = $userModel->create($username, $email, $hashed);

        if (!$created) {
            Response::json(['error' => 'Erro ao criar usuario'], 500);
        }

        Response::json(['message' => 'Usuario criado com sucesso'], 201);
    }

    public function login()
    {
        $data = $this->getRequestData();

        if (!is_array($data)) {
            Response::json(['error' => 'Dados da requisicao invalidos'], 400);
        }

        $email = trim($data['email'] ?? '');
        $password = $data['senha'] ?? '';

        if ($email === '' || $password === '') {
            Response::json(['error' => 'Campos obrigatorios'], 400);
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['senha'])) {
            Response::json(['error' => 'Credenciais invalidas'], 401);
        }

        try {
            $jwt = new JWTHandler();
            $token = $jwt->generate($user);
        } catch (\Throwable $e) {
            Response::json(['error' => 'Erro ao gerar token'], 500);
        }

        Response::json([
            'message' => 'Login OK',
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'] ?? null,
            ],
        ]);
    }
}
