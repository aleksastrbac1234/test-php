<?php

namespace App\Middleware;

class AdminMiddleware
{
    public function handle()
    {
        if (($_SESSION['user_role'] ?? null) !== 'admin') {
            http_response_code(403);
            view('403');
            exit;
        }
    }
}