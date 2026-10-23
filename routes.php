<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);