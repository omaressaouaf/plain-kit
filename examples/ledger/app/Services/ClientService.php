<?php

namespace Services;

use Omaressaouaf\PlainKit\App;
use Repositories\ClientRepository;

class ClientService
{
    private ClientRepository $clientRepository;

    public function __construct()
    {
        $this->clientRepository = App::resolve(ClientRepository::class);
    }

    public function get(): array
    {
        return $this->clientRepository->get();
    }

    public function create(string $name): void
    {
        $this->clientRepository->create($name);
    }
}
