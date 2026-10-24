<?php

namespace App\Services;

use App\Interfaces\EventRepositoryInterface;

class EventService
{
    private EventRepositoryInterface $events;

    public function __construct(EventRepositoryInterface $events)
    {
        $this->events = $events;
    }

    public function log(string $action, ?string $target = null): void
    {
        $this->events->create(
            $_SESSION['user_id'] ?? null,
            $action,
            $target,
            $_SERVER['REMOTE_ADDR'] ?? null
        );
    }
}