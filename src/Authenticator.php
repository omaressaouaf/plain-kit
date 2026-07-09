<?php

namespace Omaressaouaf\PlainKit;

class Authenticator
{
    private Database $database;

    private Session $session;

    public function __construct()
    {
        $this->database = App::resolve(Database::class);

        $this->session = App::resolve(Session::class);
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->database
            ->query('select * from users where email = :email', ['email' => $email])
            ->find();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $this->login($user);

        return true;
    }

    public function updatePassword(string $password): void
    {
        $userId = $this->user()['id'];

        $this->database->query('UPDATE users SET password=:password where id=:id', [
            'id' => $userId,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
    }

    public function login(array $user): void
    {
        $this->session->put('user', $user);

        session_regenerate_id(true);
    }

    public function logout(): void
    {
        $this->session->destroy();
    }

    public function user(): array|null
    {
        return $this->session->get('user');
    }

    public function check(): bool
    {
        return $this->session->has('user');
    }
}
