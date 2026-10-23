CREATE DATABASE IF NOT EXISTS activity_tracker CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE activity_tracker;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    action ENUM('login', 'logout', 'registration', 'view_page', 'button_click') NOT NULL,
    target VARCHAR(50) NULL,
    ip VARCHAR(45) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX (created_at),
    INDEX (user_id, created_at),
    INDEX (action, target, created_at)
);
