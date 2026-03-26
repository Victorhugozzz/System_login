<?php

require_once __DIR__ . '/../bootstrap.php';

use Victor\SystemLogin\Controllers\AuthController;
use Victor\SystemLogin\Core\Session;

$auth = new AuthController();
$error = Session::getFlash('error');
$success = Session::getFlash('success');
$resetLink = Session::getFlash('reset_link');
$auth->forgotPassword();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
</head>

<body>
    <h2>RECUPERAR SENHA</h2>
    <?php if ($error): ?>
        <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if ($resetLink): ?>
        <p><a href="<?php echo htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8'); ?>">Abrir link de redefinicao</a></p>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit">Enviar</button>
    </form>
</body>

</html>
