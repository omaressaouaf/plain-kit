<?php

function base_path(string $path): string
{
    $base = defined('PLAINKIT_BASE_PATH')
        ? PLAINKIT_BASE_PATH
        : dirname(__DIR__) . '/';

    return $base . $path;
}

function app_path(string $path): string
{
    return base_path('app/' . $path);
}

function dd(mixed ...$value): void
{
    var_dump(...$value);

    exit();
}

function _r(mixed $value): void
{
    echo htmlspecialchars($value);
}
