<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Middleware;

use Omaressaouaf\PlainKit\Exceptions\MiddlewareNotFoundException;

class Middleware
{
    protected const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
        'csrf' => VerifyCsrf::class,
    ];

    public function resolve(string $middlewareKey): void
    {
        if (! isset(static::MAP[$middlewareKey])) {
            throw new MiddlewareNotFoundException("middleware key not found => '{$middlewareKey}'");
        }

        /** @var MiddlewareInterface $middleware */
        $middleware = new (static::MAP[$middlewareKey])();

        $middleware->handle();
    }
}
