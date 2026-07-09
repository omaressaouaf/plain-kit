<?php

declare(strict_types=1);

use Dotenv\Dotenv;

function base_path(string $path = ''): string
{
    if (! defined('PLAINKIT_BASE_PATH')) {
        throw new \RuntimeException(
            'PLAINKIT_BASE_PATH is not defined. Call App::create() or define it before using base_path().'
        );
    }

    return PLAINKIT_BASE_PATH . $path;
}

function app_path(string $path): string
{
    return base_path('app/' . $path);
}

function load_env(string $basePath): void
{
    if (! is_file($basePath . '/.env')) {
        return;
    }

    Dotenv::createImmutable($basePath)->safeLoad();
}

function env(string $key, mixed $default = null): mixed
{
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }

    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    return $value;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value);
}

function _r(mixed $value): void
{
    echo e($value);
}

function dd(mixed ...$value): void
{
    var_dump(...$value);

    exit();
}
