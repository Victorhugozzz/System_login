<?php

require_once __DIR__ . '/../bootstrap.php';

use Victor\SystemLogin\Controllers\AuthController;

$auth = new AuthController();
$auth->logout();
