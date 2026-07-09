<?php

namespace Repositories;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Database;

class ClientRepository
{
    private Database $database;

    public function __construct()
    {
        $this->database = App::resolve(Database::class);
    }

    public function existsById(int $id): bool
    {
        $client = $this->database
            ->query('select * from clients where id = :id', ['id' => $id])
            ->find();

        return (bool)$client;
    }

    public function get(): array
    {
        return $this->database->query('SELECT * FROM clients ORDER BY ID DESC')->get();
    }

    public function create(string $name): void
    {
        $this->database->query('INSERT INTO clients(name) VALUES(:name)', [
            'name' => $name,
        ]);
    }
}
