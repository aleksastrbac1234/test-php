<?php


namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?array;

    public function create(string $name, string $email, string $passwordHash): int;

    public function all(): array;
}