<?php

namespace Omaressaouaf\PlainKit;

class Request
{
    public function uri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'])["path"];
    }

    public function abs_uri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function method(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function data(): array
    {
        return $this->method() === 'GET' ? $_GET : $_POST;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->data()[$key] ?? $default;
    }
}
