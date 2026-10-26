<?php

namespace App\Controllers;

use App\Repositories\EventRepository;
use App\Services\EventService;

class PageController
{
    private EventService $events;

    public function __construct()
    {
        $this->events = new EventService(new EventRepository());
    }

    public function pageA()
    {
        $this->events->log('view_page', 'page_a');
        view('pages/page-a');
    }

    public function pageB()
    {
        $this->events->log('view_page', 'page_b');
        view('pages/page-b');
    }

    public function buyCow()
    {
        verify_csrf();

        $this->events->log('button_click', 'buy_cow');

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }

    public function download()
    {
        verify_csrf();

        $this->events->log('button_click', 'download');

        $file = BASE_PATH . '/storage/files/app.exe';

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="app.exe"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}