<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Router;

session_start();

define('PLAINKIT_BASE_PATH', dirname(__DIR__) . '/');

require dirname(__DIR__, 3) . '/vendor/autoload.php';

require base_path('bootstrap.php');

$router = App::resolve(Router::class);

require base_path('routes/web.php');

$router->handleRequest();
