<?php

namespace Victor\SystemLogin\Controllers;

use Victor\SystemLogin\Core\CSRF;
use Victor\SystemLogin\Core\Session;
use Victor\SystemLogin\Models\User;

class AuthController
{
    private function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }

    private function flashError(string $message, string $path): void
    {
        Session::setFlash('error', $message);
        $this->redirect($path);
    }

    private function flashSuccess(string $message, string $path): void
    {
        Session::setFlash('success', $message);
        $this->redirect($path);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $token = $_POST['csrf_token'] ?? '';

        if (!CSRF::validateToken($token)) {
            $this->flashError('Requisicao invalida (CSRF).', 'register.php');
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['senha'] ?? '';

        if ($username === '' || $email === '' || $password === '') {
            $this->flashError('Preencha todos os campos.', 'register.php');
        }

        $userModel = new User();

        if ($userModel->findByEmail($email)) {
            $this->flashError('Email ja cadastrado.', 'register.php');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($userModel->create($username, $email, $hashedPassword, 'user')) {
            $this->flashSuccess('Usuario criado com sucesso. Faca login para continuar.', 'login.php');
        }

        $this->flashError('Erro ao criar usuario.', 'register.php');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $token = $_POST['csrf_token'] ?? '';

        if (!CSRF::validateToken($token)) {
            $this->flashError('Requisicao invalida (CSRF).', 'login.php');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['senha'] ?? '';

        if ($email === '' || $password === '') {
            $this->flashError('Preencha todos os campos.', 'login.php');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['senha'])) {
            $this->flashError('Credenciais invalidas.', 'login.php');
        }

        if (isset($_POST['remember'])) {
            $rememberToken = bin2hex(random_bytes(32));
            $rememberExpires = date('Y-m-d H:i:s', strtotime('+30 days'));
            $userModel->updateRememberToken($user['id'], $rememberToken, $rememberExpires);

            setcookie('remember_token', $rememberToken, [
                'expires' => strtotime($rememberExpires),
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            ]);
        }

        Session::regenerate();
        Session::set('user', $user);

        $this->redirect('dashboard.php');
    }

    public function logout()
    {
        Session::start();
        $user = Session::get('user');

        if ($user && isset($user['id'])) {
            $userModel = new User();
            $userModel->clearRememberToken($user['id']);
        }

        Session::destroy();
        setcookie('remember_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        ]);

        $this->redirect('login.php');
    }

    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $email = trim($_POST['email'] ?? '');

        if ($email === '') {
            $this->flashError('Informe o email.', 'forgot.php');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $this->flashSuccess('Se o email existir, um link de recuperacao sera disponibilizado.', 'forgot.php');
        }

        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $userModel->saveResetToken($user['email'], $token, $expires);

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'] ?? '/forgot.php')), '/');
        $link = $scheme . '://' . $host . $basePath . '/reset.php?token=' . urlencode($token);

        Session::setFlash('success', 'Link de recuperacao gerado com sucesso.');
        Session::setFlash('reset_link', $link);
        $this->redirect('forgot.php');
    }
}
