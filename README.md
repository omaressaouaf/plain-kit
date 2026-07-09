# PlainKit

PlainKit is a small personal PHP toolkit for building MVC-style demos, prototypes, and coding exercises without installing a full framework.

It provides a few core components that are useful when plain PHP is enough, but you still want some structure around routing, middleware, request handling, sessions, CSRF protection, validation, simple views, and service container bindings.

PlainKit is not intended to replace Laravel, Symfony, Slim, or any production-grade framework. It exists as a lightweight foundation for small projects and as a practical way to explore framework internals.

## What This Is Not

PlainKit is not a production framework and does not try to compete with Laravel, Symfony, Slim, or other mature PHP frameworks.

It is a small personal toolkit for demos, experiments, coding exercises, and learning framework internals.

## Features

- Small router for basic HTTP routes
- Middleware support
- Request and response helpers
- Redirects and JSON responses
- Session and flash data handling
- CSRF token generation and verification
- Simple validation helpers
- Lightweight service container
- Basic form validation flow
- Simple PHP view rendering
- Optional PDO database wrapper

## Installation

```bash
composer require omaressaouaf/plain-kit
```

## Basic Usage

Define your application base path, load Composer autoloading, register bindings in a container, and let the router handle the request:

```php
<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Container;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Middleware\Middleware;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Router;
use Omaressaouaf\PlainKit\Session;

session_start();

define('PLAINKIT_BASE_PATH', __DIR__ . '/../');

require __DIR__ . '/../../vendor/autoload.php';

$container = new Container;

$container->bind(Session::class, fn () => new Session);
$container->bind(Csrf::class, fn () => new Csrf);
$container->bind(Middleware::class, fn () => new Middleware);
$container->bind(Request::class, fn () => new Request);
$container->bind(Response::class, fn () => new Response);
$container->bind(Router::class, fn () => new Router);

App::setContainer($container);

$router = App::resolve(Router::class);

$router->get('/', 'home');

$router->handleRequest();
```

Register routes in a separate file and point controllers to PHP files under `app/Http/Controllers`. Views are rendered with `Response::view()`, and middleware keys like `auth`, `guest`, and `csrf` are resolved automatically.

See `examples/ledger` for a fuller setup with repositories, services, forms, and authentication.

## Example App

A small ledger demo app is included in `examples/ledger` to show how the toolkit can be used in a simple MVC-style application.

## Testing

```bash
composer install
composer test
composer format:test
```

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
