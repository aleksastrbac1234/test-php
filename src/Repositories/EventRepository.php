<?php


namespace App\Repositories;

use App\Core\Database;
use App\Interfaces\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    public function create(?int $userId, string $action, ?string $target, ?string $ip): void
    {
        $stmt = Database::get()->prepare('INSERT INTO events (user_id, action, target, ip) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $action, $target, $ip]);
    }
}
