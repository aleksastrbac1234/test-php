<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['user_id'])) {
            flash('Please log in to continue.');
            redirect('/login');
        }
    }
}