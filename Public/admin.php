<?php

require_once __DIR__ . '/../bootstrap.php';

use Victor\SystemLogin\Core\Session;
use Victor\SystemLogin\Middleware\AuthMiddleware;

AuthMiddleware::check();
AuthMiddleware::isAdmin();

$user = Session::get('user');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
</head>

<body>
    <h2>Painel Admin</h2>
    <p>Bem-vindo, <?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?> (ADMIN)</p>
</body>

</html>
