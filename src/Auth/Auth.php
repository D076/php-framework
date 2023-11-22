<?php

namespace D076\PhpFramework\Auth;

class Auth implements AuthInterface
{
    public function attempt(string $username, string $password): bool
    {
        $user = app()->db->first($this->table(), [
            $this->username() => $username,
        ]);

        if (! $user) {
            return false;
        }

        if (! password_verify($password, $user[$this->password()])) {
            return false;
        }

        app()->session->set($this->sessionField(), $user['id']);

        return true;
    }

    public function check(): bool
    {
        return app()->session->has($this->sessionField());
    }

    public function user(): ?User
    {
        if (! $this->check()) {
            return null;
        }

        $user = app()->db->first($this->table(), [
            'id' => app()->session->get($this->sessionField()),
        ]);

        if ($user) {
            return new User(
                $user['id'],
                $user['name'] ?? null,
                $user[$this->username()],
                $user[$this->password()],
            );
        }

        return null;
    }

    public function logout(): void
    {
        app()->session->remove($this->sessionField());
    }

    public function table(): string
    {
        return config('auth.table', 'users');
    }

    public function username(): string
    {
        return config('auth.username', 'email');
    }

    public function password(): string
    {
        return config('auth.password', 'password');
    }

    public function sessionField(): string
    {
        return config('auth.session_field', 'user_id');
    }

    public function id(): ?int
    {
        return app()->session->get($this->sessionField());
    }
}
