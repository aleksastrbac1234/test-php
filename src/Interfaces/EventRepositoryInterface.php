<?php


namespace App\Interfaces;

interface EventRepositoryInterface
{
    public function create(?int $userId, string $action, ?string $target, ?string $ip): void;
}