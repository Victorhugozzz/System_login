<?php

namespace Victor\SystemLogin\Models;

use PDO;
use Victor\SystemLogin\Core\Database;

class User
{
    private $conn;
    private $table = 'users';
    private ?bool $hasRememberTokenExpiresColumn = null;

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

    public function saveResetToken($email, $token, $expires)
    {
        $query = "UPDATE {$this->table}
            SET reset_token = :token, reset_token_expires = :expires
            WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':token' => $token,
            ':expires' => $expires,
            ':email' => $email,
        ]);
    }

    public function findByResetToken($token)
    {
        $query = "SELECT * FROM {$this->table}
            WHERE reset_token = :token
            AND reset_token_expires > NOW()
            LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([':token' => $token]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($email, $password)
    {
        $query = "UPDATE {$this->table}
            SET senha = :password, reset_token = NULL, reset_token_expires = NULL
            WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':password' => $password,
            ':email' => $email,
        ]);
    }

    public function updateRememberToken($userId, $token, $expires)
    {
        if ($this->hasRememberTokenExpiresColumn()) {
            $query = "UPDATE {$this->table}
                SET remember_token = :token, remember_token_expires = :expires
                WHERE id = :id";
            $params = [
                ':token' => $token,
                ':expires' => $expires,
                ':id' => $userId,
            ];
        } else {
            $query = "UPDATE {$this->table}
                SET remember_token = :token
                WHERE id = :id";
            $params = [
                ':token' => $token,
                ':id' => $userId,
            ];
        }

        $stmt = $this->conn->prepare($query);

        return $stmt->execute($params);
    }

    public function findByToken($token)
    {
        if ($this->hasRememberTokenExpiresColumn()) {
            $query = "SELECT * FROM {$this->table}
                WHERE remember_token = :token
                AND remember_token_expires > NOW()
                LIMIT 1";
        } else {
            $query = "SELECT * FROM {$this->table}
                WHERE remember_token = :token
                LIMIT 1";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute([':token' => $token]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function clearRememberToken($userId)
    {
        if ($this->hasRememberTokenExpiresColumn()) {
            $query = "UPDATE {$this->table}
                SET remember_token = NULL, remember_token_expires = NULL
                WHERE id = :id";
        } else {
            $query = "UPDATE {$this->table}
                SET remember_token = NULL
                WHERE id = :id";
        }

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => $userId,
        ]);
    }

    private function hasRememberTokenExpiresColumn(): bool
    {
        if ($this->hasRememberTokenExpiresColumn !== null) {
            return $this->hasRememberTokenExpiresColumn;
        }

        $query = "SELECT 1
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = :table
            AND COLUMN_NAME = :column
            LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':table' => $this->table,
            ':column' => 'remember_token_expires',
        ]);

        $this->hasRememberTokenExpiresColumn = (bool) $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->hasRememberTokenExpiresColumn;
    }
}
