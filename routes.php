<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\ReportController;
use App\Controllers\StatisticsController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;

/** @var App\Core\Router $router */

$router->get('/', [HomeController::class, 'index']);

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);

$router->get('/page-a', [PageController::class, 'pageA'], [AuthMiddleware::class]);
$router->get('/page-b', [PageController::class, 'pageB'], [AuthMiddleware::class]);
$router->post('/buy-cow', [PageController::class, 'buyCow'], [AuthMiddleware::class]);
$router->post('/download', [PageController::class, 'download'], [AuthMiddleware::class]);

$router->get('/statistics', [StatisticsController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
$router->get('/reports', [ReportController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);