<?php

return [
    'key' => $_ENV['JWT_SECRET'] ?? 'troque-esta-chave-jwt-em-producao',
    'issuer' => $_ENV['JWT_ISSUER'] ?? 'localhost',
    'audience' => $_ENV['JWT_AUDIENCE'] ?? 'localhost',
    'expires' => (int) ($_ENV['JWT_EXPIRES'] ?? 3600),
];
