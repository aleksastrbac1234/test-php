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

    public function getFiltered(array $filters, int $limit, int $offset): array
    {
        [$where, $params] = $this->buildFilters($filters);

        $stmt = Database::get()->prepare("
        SELECT events.*, users.name AS user_name
        FROM events
        LEFT JOIN users ON users.id = events.user_id
        $where
        ORDER BY events.created_at DESC, events.id DESC
        LIMIT $limit OFFSET $offset
    ");
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function countFiltered(array $filters): int
    {
        [$where, $params] = $this->buildFilters($filters);

        $stmt = Database::get()->prepare("SELECT COUNT(*) FROM events $where");
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    private function buildFilters(array $filters): array
    {
        $conditions = [];
        $params = [];

        if ($filters['date_from']) {
            $conditions[] = 'events.created_at >= ?';
            $params[] = $filters['date_from'] . ' 00:00:00';
        }

        if ($filters['date_to']) {
            $conditions[] = 'events.created_at < ?';
            $params[] = date('Y-m-d', strtotime($filters['date_to'] . ' +1 day'));
        }

        if ($filters['user_id']) {
            $conditions[] = 'events.user_id = ?';
            $params[] = $filters['user_id'];
        }

        if ($filters['action']) {
            $conditions[] = 'events.action = ?';
            $params[] = $filters['action'];
        }

        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

        return [$where, $params];
    }

    public function dailyCounts(string $from, string $to): array
    {
        $stmt = Database::get()->prepare("
        SELECT
            DATE(created_at) AS date,
            SUM(action = 'view_page' AND target = 'page_a') AS page_a_views,
            SUM(action = 'view_page' AND target = 'page_b') AS page_b_views,
            SUM(action = 'button_click' AND target = 'buy_cow') AS buy_cow_clicks,
            SUM(action = 'button_click' AND target = 'download') AS download_clicks
        FROM events
        WHERE created_at >= ?
          AND created_at < ?
          AND action IN ('view_page', 'button_click')
        GROUP BY DATE(created_at)
        ORDER BY date
    ");
        $stmt->execute([$from . ' 00:00:00', date('Y-m-d', strtotime($to . ' +1 day'))]);

        return $stmt->fetchAll();
    }
}
