<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Response;

$response = App::resolve(Response::class);

$response->view("auth/register");
