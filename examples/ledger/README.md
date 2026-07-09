# Ledger Example

This is a small example application built with PlainKit.

It demonstrates how the toolkit can be used to structure a simple MVC-style PHP application with routing, views, repositories, services, sessions, validation, authentication, and CSRF protection.

This example is intentionally small and exists only to demonstrate usage of the package.

## Setup

From the repository root:

```bash
composer install
```

Edit database credentials in `examples/ledger/config/app.php` if needed.

Run the migration script to create the database and tables:

```bash
php examples/ledger/database/migrate.php
```

Launch the demo app with PHP's built-in server:

```bash
php -S localhost:8080 -t examples/ledger/public
```

You can register a user, log in, manage clients and transactions, view reports, and access the JSON API at `/api/reports`.
