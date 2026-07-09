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

Load Composer autoloading, create an application, register your bindings, and run:

```php
<?php

use Omaressaouaf\PlainKit\App;

require __DIR__ . '/../../vendor/autoload.php';

App::create(__DIR__ . '/../')
    ->bind(HomeController::class, fn () => new HomeController())
    ->run();
```

`App::create()` sets the base path, starts the session, and registers the default PlainKit bindings. Chain `bind()` calls for your own services:

```php
App::create(__DIR__ . '/../')
    ->bind(HomeController::class, fn () => new HomeController())
    ->run();
```

Register routes in `routes/web.php` and point controllers to PHP files under `app/Http/Controllers`. Views are rendered with `Response::view()`, and middleware keys like `auth`, `guest`, and `csrf` are resolved automatically.

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
