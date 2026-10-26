<?php

namespace App\Services;

use App\Interfaces\EventRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;


class StatisticsService
{
    private const PER_PAGE = 20;
    private const ACTIONS = ['login', 'logout', 'registration', 'view_page', 'button_click'];

    private EventRepositoryInterface $events;
    private UserRepositoryInterface $users;

    public function __construct(EventRepositoryInterface $events, UserRepositoryInterface $users)
    {
        $this->events = $events;
        $this->users = $users;
    }

    public function getEvents(array $input): array
    {
        $filters = [
            'date_from' => valid_date($input['date_from'] ?? ''),
            'date_to' => valid_date($input['date_to'] ?? ''),
            'user_id' => (int) ($input['user_id'] ?? 0) ?: null,
            'action' => in_array($input['action'] ?? '', self::ACTIONS, true) ? $input['action'] : null,
        ];

        $total = $this->events->countFiltered($filters);
        $pages = max(1, (int) ceil($total / self::PER_PAGE));
        $page = min(max(1, (int) ($input['page'] ?? 1)), $pages);

        return [
            'events' => $this->events->getFiltered($filters, self::PER_PAGE, ($page - 1) * self::PER_PAGE),
            'filters' => $filters,
            'users' => $this->users->all(),
            'actions' => self::ACTIONS,
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
        ];
    }

}