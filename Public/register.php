<?php

require_once __DIR__ . '/../bootstrap.php';

use Victor\SystemLogin\Controllers\AuthController;
use Victor\SystemLogin\Core\CSRF;
use Victor\SystemLogin\Core\Session;

$auth = new AuthController();
$auth->register();

$csrfToken = CSRF::generateToken();
$error = Session::getFlash('error');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <form method="POST">
            <h1>Crie uma conta</h1>
            <?php if ($error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <div class="input-box">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="text" name="username" placeholder="Nome">
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email">
            </div>
            <div class="input-box">
                <input type="password" name="senha" placeholder="Senha">
            </div>
            <div class="register-link">
                <p>Voce tem uma conta? <a href="login.php">Logar</a></p>
            </div>
            <button class="btn" type="submit">Cadastrar</button>
        </form>
    </div>
</body>

</html>
