<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Authenticator;
use Omaressaouaf\PlainKit\Response;

$response = App::resolve(Response::class);
$authenticator = App::resolve(Authenticator::class);

$authenticator->logout();

$response->redirect('/login');
