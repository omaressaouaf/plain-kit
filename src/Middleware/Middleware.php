<?php

namespace Omaressaouaf\PlainKit\Middleware;

class Middleware
{
    protected const MAP = [
        "guest" => Guest::class,
        "auth" => Auth::class,
        "csrf" => VerifyCsrf::class,
    ];

    public function resolve(string $middlewareKey): void
    {
        if (! isset(static::MAP[$middlewareKey])) {
            throw new \Exception("middleware key not found => '{$middlewareKey}'");
        }

        $middleware = new (static::MAP[$middlewareKey]);

        $middleware->handle();
    }
}
