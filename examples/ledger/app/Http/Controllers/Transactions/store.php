<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Session;
use Http\Forms\StoreTransactionForm;
use Services\TransactionService;

$request = App::resolve(Request::class);
$response = App::resolve(Response::class);
$session = App::resolve(Session::class);
$transactionService = App::resolve(TransactionService::class);

StoreTransactionForm::validate();

$transactionService->create($request->input('type'), $request->input('amount'), $request->input('client_id'));

$session->flash('success', 'Transaction created successfully!');

$response->back();
