<?php

require_once __DIR__ . '/../bootstrap.php';

use Victor\SystemLogin\Core\Session;
use Victor\SystemLogin\Models\User;

$token = $_GET['token'] ?? '';

$userModel = new User();
$user = $userModel->findByResetToken($token);

if (!$user) {
    die('Token invalido ou expirado');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['senha'] ?? '';

    if ($password === '') {
        Session::setFlash('error', 'Informe a nova senha.');
        header('Location: reset.php?token=' . urlencode($token));
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $userModel->updatePassword($user['email'], $hashed);

    Session::setFlash('success', 'Senha atualizada com sucesso. Faca login.');
    header('Location: login.php');
    exit;
}

$error = Session::getFlash('error');
?>

<h2>Nova senha</h2>
<?php if ($error): ?>
    <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="password" name="senha" placeholder="Nova senha" required><br><br>
    <button type="submit">Redefinir</button>
</form>
