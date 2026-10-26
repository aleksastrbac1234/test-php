<?php

namespace App\Controllers;

use App\Repositories\EventRepository;
use App\Services\ReportService;

class ReportController
{
    private ReportService $reports;

    public function __construct()
    {
        $this->reports = new ReportService(new EventRepository());
    }

    public function index()
    {
        view('admin/reports', $this->reports->getReport($_GET));
    }
}