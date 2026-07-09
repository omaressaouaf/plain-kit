<?php

namespace Repositories;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Database;

class UserRepository
{
    private Database $database;

    public function __construct()
    {
        $this->database = App::resolve(Database::class);
    }

    public function existsByEmail(string $email): bool
    {
        $user = $this->database
            ->query('select * from users where email = :email', ['email' => $email])
            ->find();

        return (bool)$user;
    }

    public function create(string $name, string $email, string $password): void
    {
        $this->database->query('INSERT INTO users(name, email, password) VALUES(:name, :email, :password)', [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }
}
