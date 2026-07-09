# PlainKit

[![Latest Stable Version](https://img.shields.io/packagist/v/omaressaouaf/plain-kit.svg)](https://packagist.org/packages/omaressaouaf/plain-kit)
[![License](https://img.shields.io/github/license/omaressaouaf/plain-kit)](LICENSE)
[![Tests](https://github.com/omaressaouaf/plain-kit/actions/workflows/tests.yml/badge.svg)](https://github.com/omaressaouaf/plain-kit/actions/workflows/tests.yml)

A small personal PHP toolkit for building **MVC-style demos, prototypes, and coding exercises** without installing a full framework.

PlainKit gives you just enough structure around routing, middleware, request handling, sessions, CSRF protection, validation, simple views, environment configuration, and a lightweight service container — while staying close to plain PHP.

> PlainKit is **not** a production framework. It is not intended to replace Laravel, Symfony, Slim, or any mature PHP framework. It exists as a practical foundation for personal small projects, experiments, and learning how framework pieces fit together.

---

## Features

- **Application bootstrap** with `App::create()` and fluent service binding
- **Router** with HTTP verbs, middleware, route parameters, and file-based controllers
- **Middleware** for `auth`, `guest`, and CSRF verification
- **Request** and **Response** helpers for input, redirects, JSON, and views
- **Session** storage with flash data
- **CSRF** token generation and verification
- **Form validation** flow with `Form` and `Validator`
- **Authenticator** for login, logout, and password updates
- **Database** wrapper around PDO
- **Environment** loading via `.env` ([`vlucas/phpdotenv`](https://github.com/vlucas/phpdotenv))
- Global **helpers** for paths, escaping, debugging, and env access

---

## Requirements

- PHP **8.2+**
- Composer

---

## Installation

Install via Composer:

```sh
composer require omaressaouaf/plain-kit
```

---

## Quick Start

A PlainKit application needs:

1. A **public entry point** (`public/index.php`)
2. A **routes file** (`routes.php`)
3. **Controllers** under `app/Http/Controllers/`
4. **Views** under `app/Views/`
5. Optional **config**, **`.env`**, repositories, and services

### Entry point

```php
<?php

use Omaressaouaf\PlainKit\App;

require __DIR__ . '/../../vendor/autoload.php';

App::create(dirname(__DIR__))
    ->bind(ClientService::class, fn () => new ClientService())
    ->run();
```

`App::create()` will:

- set the application base path (`PLAINKIT_BASE_PATH`)
- load `.env` from the app root (if present)
- start the session
- register default PlainKit bindings
- load `routes.php` and handle the incoming request

### Routes

```php
<?php

use Omaressaouaf\PlainKit\Router;

/** @var Router $router */

$router->get('/login', 'Auth/Login/create')->middleware('guest');
$router->post('/login', 'Auth/Login/store')->middleware('guest');
$router->get('/clients', 'Clients/index')->middleware('auth');
$router->post('/clients', 'Clients/store')->middleware('auth');
$router->get('/clients/{id}', 'Clients/show')->middleware('auth');
```

Routes map to PHP files at `app/Http/Controllers/{path}.php`.

### Controller

Controllers are plain PHP files. Resolve dependencies from the container with `App::resolve()`:

```php
<?php

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
```

---

## Project Structure

A typical app built with PlainKit looks like this:

```txt
my-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Forms/
│   ├── Repositories/
│   ├── Services/
│   └── Views/
├── config/
│   └── app.php
├── database/
│   └── migrate.php
├── public/
│   └── index.php
├── routes.php
├── .env
└── .env.example
```

The **package** lives in `vendor/omaressaouaf/plain-kit`. Your **app root** is the directory passed to `App::create()` — usually one level above `public/`.

---

## Environment

PlainKit uses [`vlucas/phpdotenv`](https://github.com/vlucas/phpdotenv) to load a `.env` file from the application root.

`.env.example`:

```dotenv
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=plain_kit_ledger
DB_USERNAME=root
DB_PASSWORD=
```

`config/app.php`:

```php
<?php

return [
    'database' => [
        'connection' => [
            'host' => env('DB_HOST', 'localhost'),
            'port' => (int) env('DB_PORT', 3306),
            'dbname' => env('DB_DATABASE', 'plain_kit_ledger'),
            'charset' => 'utf8mb4',
        ],
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', ''),
    ],
];
```

Helpers:

```php
load_env('/path/to/app');   // usually called automatically by App::create()
env('DB_HOST', 'localhost'); // read a variable with optional default
```

---

## Helpers

PlainKit registers these global helpers:

| Helper                                  | Purpose                       |
| --------------------------------------- | ----------------------------- |
| `base_path('config/app.php')`           | Path relative to the app root |
| `app_path('Http/Controllers/home.php')` | Path relative to `app/`       |
| `env('KEY', 'default')`                 | Read an environment variable  |
| `load_env($basePath)`                   | Load `.env` from a directory  |
| `e($value)`                             | Escape HTML (returns string)  |
| `_r($value)`                            | Echo escaped HTML             |
| `dd(...$values)`                        | Dump and die                  |

`base_path()` requires `PLAINKIT_BASE_PATH` to be defined (via `App::create()` or manually).

---

## App & Container

### Bootstrapping

```php
App::create(dirname(__DIR__))
    ->bind(UserRepository::class, fn () => new UserRepository())
    ->bind(RegisterService::class, fn () => new RegisterService())
    ->run();
```

### Default bindings

These are registered automatically:

- `Session`
- `Csrf`
- `Middleware`
- `Request`
- `Response`
- `Router`
- `Database`
- `Authenticator`

Register your own classes with `->bind()`:

```php
->bind(ClientService::class, fn () => new ClientService())
```

### Resolving services

Inside controllers, middleware, forms, repositories, or views:

```php
$request = App::resolve(Request::class);
$userRepository = App::resolve(UserRepository::class);
```

If a binding is missing, PlainKit throws `BindingNotFoundException`.

---

## Router

### HTTP verbs

```php
$router->get('/reports', 'Reports/index');
$router->post('/transactions', 'Transactions/store');
$router->delete('/logout', 'Auth/Login/destroy');
$router->put('/items/{id}', 'Items/update');
$router->patch('/items/{id}', 'Items/patch');
```

### Middleware

Attach middleware to the most recently registered route:

```php
$router->get('/clients', 'Clients/index')->middleware('auth');
$router->get('/login', 'Auth/Login/create')->middleware('guest');
```

Built-in middleware keys:

| Key     | Behavior                                                                            |
| ------- | ----------------------------------------------------------------------------------- |
| `auth`  | Redirect to `/login` if the user is not logged in                                   |
| `guest` | Redirect to `/` if the user is already logged in                                    |
| `csrf`  | Verify CSRF token on `POST` requests (applied automatically on every matched route) |

### Route parameters

```php
$router->get('/clients/{id}', 'Clients/show');
```

In a controller:

```php
$id = $request->params('id');
$all = $request->params(); // all route params as array
```

Place static routes before parameterized ones:

```php
$router->get('/clients/list', 'Clients/list');   // match first
$router->get('/clients/{id}', 'Clients/show');     // match second
```

### Method spoofing

HTML forms can simulate `PUT`, `PATCH`, or `DELETE` via a hidden `_method` field:

```html
<input type="hidden" name="_method" value="DELETE" />
```

The router reads `$_POST['_method']` when handling the request.

### 404 handling

When no route matches, PlainKit calls `Response::abort(404)`, which loads:

```txt
app/Http/Controllers/Failures/404.php
```

---

## Request

```php
$request = App::resolve(Request::class);

$request->uri();                          // "/clients"
$request->abs_uri();                      // "/clients?page=2"
$request->method();                         // "GET", "POST", etc.
$request->input('email');                 // from $_GET or $_POST
$request->input('email', 'default');      // with fallback
$request->params('id');                   // route parameter
$request->params();                       // all route parameters
```

---

## Response

```php
$response = App::resolve(Response::class);

// Render a view from app/Views/{name}.view.php
$response->view('clients', ['clients' => $clients]);

// JSON
$response->json(['reports' => $reports]);

// Redirect
$response->redirect('/login');

// Go back to the previous page (falls back to "/")
$response->back();

// Abort with an HTTP status code
$response->abort(404);
$response->abort(419); // CSRF failure
```

Views receive context variables via `extract()` and can include partials:

```php
$response->view('Partials/head');
$response->view('Partials/nav');
```

Use `e()` in views to escape output:

```php
<p>Welcome, <?= e($user['name']) ?>!</p>
```

---

## Session

```php
$session = App::resolve(Session::class);

$session->put('user', $user);
$session->get('user');
$session->has('user');
$session->forget('user');

// Flash data (available on the next request)
$session->flash('success', 'Saved!');
$session->flash('errors', ['email' => 'Invalid email']);
$session->get('success');
```

Flash data is cleared automatically at the end of each request via `Router::handleRequest()`.

---

## CSRF

Generate a token in a form:

```php
$csrf = App::resolve(Csrf::class);
```

```html
<input type="hidden" name="_csrf_token" value="<?= $csrf->generate() ?>" />
```

`VerifyCsrf` middleware runs on every matched route. On `POST` requests it checks the submitted `_csrf_token`. Invalid or missing tokens trigger a `419` response.

---

## Forms & Validation

### Creating a form

Extend `Form` and implement `handle()`:

```php
<?php

namespace Http\Forms;

use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Validator;

class LoginForm extends Form
{
    protected function handle(): void
    {
        if (! Validator::exists($this->request->input('email'))
            || ! Validator::email($this->request->input('email'))) {
            $this->addError('email', 'Email must be valid');
        }

        if (! Validator::exists($this->request->input('password'))) {
            $this->addError('password', 'Password is required');
        }
    }
}
```

### Validating in a controller

```php
LoginForm::validate();
```

If validation fails, PlainKit throws `ValidationException`. The router catches it, flashes `errors` and `old` input to the session, and redirects back.

Display errors in a view partial:

```php
$errors = $session->get('errors');
```

### Validator methods

| Method                          | Description              |
| ------------------------------- | ------------------------ |
| `Validator::exists($value)`     | Not empty                |
| `Validator::email($value)`      | Valid email              |
| `Validator::string($value)`     | Non-empty trimmed string |
| `Validator::numeric($value)`    | Numeric value            |
| `Validator::in($value, $array)` | Value in array           |
| `Validator::min($value, $min)`  | Min length/count/numeric |
| `Validator::max($value, $max)`  | Max length/count/numeric |

---

## Database

PlainKit includes a thin PDO wrapper. Configuration is read from `config/app.php`.

```php
$database = App::resolve(Database::class);

$users = $database
    ->query('SELECT * FROM users WHERE email = :email', ['email' => $email])
    ->get();

$user = $database
    ->query('SELECT * FROM users WHERE id = :id', ['id' => $id])
    ->find();

$user = $database
    ->query('SELECT * FROM users WHERE id = :id', ['id' => $id])
    ->findOrFail(); // aborts with 404 if not found
```

Typical usage in a repository:

```php
<?php

namespace Repositories;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Database;

class ClientRepository
{
    private Database $database;

    public function __construct()
    {
        $this->database = App::resolve(Database::class);
    }

    public function get(): array
    {
        return $this->database
            ->query('SELECT * FROM clients ORDER BY id DESC')
            ->get();
    }
}
```

---

## Authenticator

Session-based authentication helper:

```php
$authenticator = App::resolve(Authenticator::class);

// Login attempt
if ($authenticator->attempt($email, $password)) {
    $response->redirect('/');
}

// Current user
$authenticator->user();   // array|null
$authenticator->check();   // bool

// Logout
$authenticator->logout();

// Update password for the logged-in user
$authenticator->updatePassword($newPassword);
```

On successful login, the user record is stored in the session under the `user` key and the session ID is regenerated.

---

## Middleware

All middleware implements `MiddlewareInterface`:

```php
interface MiddlewareInterface
{
    public function handle(): void;
}
```

Built-in middleware is resolved by key through the `Middleware` class. To add custom middleware you would extend the middleware map in your own fork or wrapper — PlainKit keeps this intentionally small.

---

## Exceptions

| Exception                     | When                                                  |
| ----------------------------- | ----------------------------------------------------- |
| `BindingNotFoundException`    | Container binding not registered                      |
| `MiddlewareNotFoundException` | Unknown middleware key                                |
| `ValidationException`         | Form validation failed (carries `$errors` and `$old`) |

---

## Example App

This repository includes a **ledger demo** at [`examples/ledger`](examples/ledger) that demonstrates:

- user registration and login
- CRUD for clients and transactions
- filtered reports
- a JSON API endpoint at `/api/reports`
- forms, repositories, services, CSRF, and middleware

### Run the example

From the repository root:

```sh
composer install
cp examples/ledger/.env.example examples/ledger/.env
php examples/ledger/database/migrate.php
php -S localhost:8080 -t examples/ledger/public
```

See [`examples/ledger/README.md`](examples/ledger/README.md) for more detail.

---

## Testing

Run unit tests:

```sh
composer test
```

---

## License

This package is licensed under the [MIT License](LICENSE).
