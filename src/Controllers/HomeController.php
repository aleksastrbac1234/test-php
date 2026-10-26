<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        redirect(isset($_SESSION['user_id']) ? '/page-a' : '/login');
    }
}