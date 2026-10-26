<?php


namespace App\Repositories;

use App\Core\Database;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?array
    {
        $stmt = Database::get()->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);

        return $stmt->fetch() ?: null;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $stmt = Database::get()->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $passwordHash]);

        return (int)Database::get()->lastInsertId();
    }
    public function all(): array
    {
        return Database::get()->query('SELECT id, name, email FROM users ORDER BY name')->fetchAll();
    }
}