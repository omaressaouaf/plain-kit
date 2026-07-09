<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Response;
use Services\ClientService;

$response = App::resolve(Response::class);
$clientService = App::resolve(ClientService::class);

$clients = $clientService->get();

$response->view("clients", [
    'clients' => $clients
]);
