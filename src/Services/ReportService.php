<?php

namespace App\Services;

use App\Interfaces\EventRepositoryInterface;
use DateInterval;
use DatePeriod;
use DateTime;

class ReportService
{
    private EventRepositoryInterface $events;

    public function __construct(EventRepositoryInterface $events)
    {
        $this->events = $events;
    }

    public function getReport(array $input): array
    {
        $to = valid_date($input['date_to'] ?? '') ?? date('Y-m-d');
        $from = valid_date($input['date_from'] ?? '') ?? date('Y-m-d', strtotime($to . ' -29 days'));

        if ($from > $to) {
            [$from, $to] = [$to, $from];
        }

        $counts = [];
        foreach ($this->events->dailyCounts($from, $to) as $row) {
            $counts[$row['date']] = $row;
        }

        $rows = [];
        $period = new DatePeriod(new DateTime($from), new DateInterval('P1D'), (new DateTime($to))->modify('+1 day'));

        foreach ($period as $day) {
            $date = $day->format('Y-m-d');

            $rows[] = [
                'date' => $date,
                'page_a_views' => (int) ($counts[$date]['page_a_views'] ?? 0),
                'page_b_views' => (int) ($counts[$date]['page_b_views'] ?? 0),
                'buy_cow_clicks' => (int) ($counts[$date]['buy_cow_clicks'] ?? 0),
                'download_clicks' => (int) ($counts[$date]['download_clicks'] ?? 0),
            ];
        }

        return [
            'rows' => $rows,
            'from' => $from,
            'to' => $to,
        ];
    }
}