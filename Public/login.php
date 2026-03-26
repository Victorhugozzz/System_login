<?php

require_once __DIR__ . '/../bootstrap.php';

use Victor\SystemLogin\Controllers\AuthController;
use Victor\SystemLogin\Core\CSRF;
use Victor\SystemLogin\Core\Session;

$csrf_token = CSRF::generateToken();
$auth = new AuthController();
$error = Session::getFlash('error');
$success = Session::getFlash('success');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <form method="POST">
            <h1>Login</h1>
            <?php if ($error): ?>
                <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <div class="input-box">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <input type="email" name="email" placeholder="Email" required>
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
                <input type="password" name="senha" placeholder="Password" required>
                <i class="bx bx-lock"></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Lembre me</label>
                <a href="forgot.php">Esqueceu a senha?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register-link">
                <p>Voce nao tem uma conta? <a href="register.php">Registrar</a></p>
            </div>
        </form>
    </div>
    <script src="./assets/js/script.js"></script>
</body>

</html>
