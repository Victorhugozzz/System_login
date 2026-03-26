<?php

namespace Victor\SystemLogin\Api\Core;

use PDO;
use PDOException;

class Database
{
    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private static ?PDO $pdo = null;

    public function connect()
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        try {
            self::$pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            return self::$pdo;
        } catch (PDOException $e) {
            die('Erro na conexao: ' . $e->getMessage());
        }
    }
}
