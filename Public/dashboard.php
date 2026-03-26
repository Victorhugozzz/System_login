<?php

require_once __DIR__ . '/../bootstrap.php';

use Victor\SystemLogin\Core\Session;
use Victor\SystemLogin\Middleware\AuthMiddleware;
use Victor\SystemLogin\Models\User;

Session::start();
$user = Session::get('user');

if (!$user && isset($_COOKIE['remember_token'])) {
    $userModel = new User();
    $user = $userModel->findByToken($_COOKIE['remember_token']);

    if ($user) {
        Session::set('user', $user);
    }
}

AuthMiddleware::check();
$user = Session::get('user');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./assets/css/styledash.css">
</head>

<body>
    <div class="all">
        <div class="card">
            <nav class="menu">
                <p>Home</p>
                <p>About</p>
                <p>Contacts</p>
            </nav>
        </div>
        <div class="card2">
            <div class="content">
                <p>Hello, <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?> ! <br>Muito obrigado por usar meu site.</p>
                <p>Tenha um bom dia !<span style="font-size:20px;">&#128077;</span></p>
                <p>Para sair aperte aqui -> <a href="logout.php">Log out</a></p>
                <button><a href="admin.php">Admin</a></button>
            </div>
        </div>
    </div>
</body>

</html>
