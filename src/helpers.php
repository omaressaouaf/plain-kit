<?php

function base_path(string $path): string
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

function dd(mixed ...$value): void
{
    var_dump(...$value);

    exit();
}

function _r(mixed $value): void
{
    echo htmlspecialchars($value);
}
