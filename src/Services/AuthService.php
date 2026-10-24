<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;

class AuthService
{
    private UserRepositoryInterface $users;
    private EventService $events;

    public function __construct(UserRepositoryInterface $users, EventService $events)
    {
        $this->users = $users;
        $this->events = $events;
    }

    public function register(array $data): array
    {
        $name = trim($data['name'] ?? '');
        $email = strtolower(trim($data['email'] ?? ''));
        $password = $data['password'] ?? '';
        $confirmation = $data['password_confirmation'] ?? '';

        $errors = $this->validateRegistration($name, $email, $password, $confirmation);

        if ($errors) {
            return $errors;
        }

        $userId = $this->users->create($name, $email, password_hash($password, PASSWORD_DEFAULT));

        $this->loginUser($userId, 'user');
        $this->events->log('registration');

        return [];
    }

    private function validateRegistration(string $name, string $email, string $password, string $confirmation): array
    {
        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Name is required.';
        } elseif (mb_strlen($name) > 100) {
            $errors['name'] = 'Name can have at most 100 characters.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter a valid email address.';
        } elseif ($this->users->findByEmail($email)) {
            $errors['email'] = 'This email is already registered.';
        }

        if (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters.';
        } elseif ($password !== $confirmation) {
            $errors['password'] = 'Passwords do not match.';
        }

        return $errors;
    }

    private function loginUser(int $userId, string $role): void
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = $role;
    }
}