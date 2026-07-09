<?php

use Omaressaouaf\PlainKit\Router;

/** @var Router $router */

// Auth routes
$router->get('/login', 'Auth/Login/create')->middleware('guest');
$router->post('/login', 'Auth/Login/store')->middleware('guest');
$router->delete('/logout', 'Auth/Login/destroy')->middleware('auth');
$router->get('/register', 'Auth/Register/create')->middleware('guest');
$router->post('/register', 'Auth/Register/store')->middleware('guest');
$router->get('/password', 'Auth/Password/create')->middleware('auth');
$router->post('/password', 'Auth/Password/store')->middleware('auth');

// Admin routes
$router->get('/', 'home')->middleware('auth');

$router->get('/clients', 'Clients/index')->middleware('auth');
$router->post('/clients', 'Clients/store')->middleware('auth');

$router->get('/transactions', 'Transactions/index')->middleware('auth');
$router->post('/transactions', 'Transactions/store')->middleware('auth');

$router->get('/reports', 'Reports/index')->middleware('auth');

// Api routes
$router->get('/api/reports', 'Api/Reports/index')->middleware('auth');
