<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Response;

$response = App::resolve(Response::class);

$response->view("auth/register");
