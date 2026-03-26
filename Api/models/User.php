<?php

namespace Victor\SystemLogin\Api\Models;

use PDO;
use Victor\SystemLogin\Api\Core\Database;

class User
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function create($username, $email, $senha, $role = 'user')
    {
        $query = "INSERT INTO {$this->table} (username, email, senha, role)
                  VALUES (:username, :email, :senha, :role)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':senha' => $senha,
            ':role' => $role,
        ]);
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
