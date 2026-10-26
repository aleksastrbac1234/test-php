<?php

namespace App\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use App\Services\StatisticsService;

class StatisticsController
{
    private StatisticsService $statistics;

    public function __construct()
    {
        $this->statistics = new StatisticsService(new EventRepository(), new UserRepository());
    }

    public function index()
    {
        view('admin/statistics', $this->statistics->getEvents($_GET));
    }
}