<?php


namespace App\Interfaces;

interface EventRepositoryInterface
{
    public function create(?int $userId, string $action, ?string $target, ?string $ip): void;

    public function getFiltered(array $filters, int $limit, int $offset): array;

    public function countFiltered(array $filters): int;

    public function dailyCounts(string $from, string $to): array;
}