<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Authenticator;
use Omaressaouaf\PlainKit\Container;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Database;
use Omaressaouaf\PlainKit\Middleware\Middleware;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Router;
use Omaressaouaf\PlainKit\Session;
use Repositories\ClientRepository;
use Repositories\TransactionRepository;
use Repositories\UserRepository;
use Services\ClientService;
use Services\RegisterService;
use Services\TransactionService;

$container = new Container();

$bindings = [
    Session::class => fn () => new Session(),
    Csrf::class => fn () => new Csrf(),
    Middleware::class => fn () => new Middleware(),
    Request::class => fn () => new Request(),
    Response::class => fn () => new Response(),
    Router::class => fn () => new Router(),
    Database::class => fn () => new Database(),
    Authenticator::class => fn () => new Authenticator(),
    UserRepository::class => fn () => new UserRepository(),
    RegisterService::class => fn () => new RegisterService(),
    ClientRepository::class => fn () => new ClientRepository(),
    ClientService::class => fn () => new ClientService(),
    TransactionRepository::class => fn () => new TransactionRepository(),
    TransactionService::class => fn () => new TransactionService(),
];

foreach ($bindings as $key => $resolver) {
    $container->bind($key, $resolver);
}

App::setContainer($container);
