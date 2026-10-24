<?php

namespace App\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\EventService;

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService(
            new UserRepository(),
            new EventService(new EventRepository())
        );
    }

    public function showRegister()
    {
        view('auth/register');
    }

    public function register()
    {
        verify_csrf();

        $errors = $this->authService->register($_POST);

        if ($errors) {
            view('auth/register', ['errors' => $errors, 'old' => $_POST]);
            return;
        }

        flash('Your account has been created. Welcome!');
        redirect('/page-a');
    }

    public function showLogin()
    {
        view('auth/login');
    }

    public function login()
    {
        verify_csrf();

        if (!$this->authService->login($_POST['email'] ?? '', $_POST['password'] ?? '')) {
            view('auth/login', ['error' => 'Invalid email or password.', 'old' => $_POST]);
            return;
        }

        flash('Welcome back!');
        redirect('/page-a');
    }

    public function logout()
    {
        verify_csrf();

        $this->authService->logout();

        flash('You have been logged out.');
        redirect('/login');
    }
}