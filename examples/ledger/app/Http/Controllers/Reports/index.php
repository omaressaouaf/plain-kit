<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Services\TransactionService;

$request = App::resolve(Request::class);
$response = App::resolve(Response::class);
$transactionService = App::resolve(TransactionService::class);

$reports = $transactionService->getReports($request->input('start_date'), $request->input('end_date'));

$response->view("reports", [
    'reports' => $reports,
]);
