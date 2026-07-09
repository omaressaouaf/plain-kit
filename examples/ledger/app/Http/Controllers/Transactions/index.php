<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Response;
use Services\ClientService;
use Services\TransactionService;

$response = App::resolve(Response::class);
$transactionService = App::resolve(TransactionService::class);
$clientService = App::resolve(ClientService::class);

$transactions = $transactionService->get();
$clients = $clientService->get();

$response->view("transactions", [
    'transactions' => $transactions,
    'clients' => $clients,
]);
