<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Session;
use Http\Forms\StoreClientForm;
use Services\ClientService;

$request = App::resolve(Request::class);
$response = App::resolve(Response::class);
$session = App::resolve(Session::class);
$clientService = App::resolve(ClientService::class);

StoreClientForm::validate();

$clientService->create($request->input('name'));

$session->flash('success', 'Client created successfully!');

$response->back();
