<?php

declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Repositories\ClientRepository;
use Repositories\TransactionRepository;
use Repositories\UserRepository;
use Services\ClientService;
use Services\RegisterService;
use Services\TransactionService;

require dirname(__DIR__, 3) . '/vendor/autoload.php';

App::create(dirname(__DIR__))
    ->bind(UserRepository::class, fn () => new UserRepository())
    ->bind(RegisterService::class, fn () => new RegisterService())
    ->bind(ClientRepository::class, fn () => new ClientRepository())
    ->bind(ClientService::class, fn () => new ClientService())
    ->bind(TransactionRepository::class, fn () => new TransactionRepository())
    ->bind(TransactionService::class, fn () => new TransactionService())
    ->run();
