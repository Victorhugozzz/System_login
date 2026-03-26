CREATE DATABASE IF NOT EXISTS system_login;
USE system_login;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    remember_token VARCHAR(255) NULL,
    remember_token_expires DATETIME NULL,
    reset_token VARCHAR(255) NULL,
    reset_token_expires DATETIME NULL
);

select * from users;

ALTER TABLE users
ADD COLUMN remember_token_expires DATETIME NULL AFTER remember_token;

ALTER TABLE users
ADD COLUMN reset_token_expires DATETIME NULL AFTER reset_token;


