<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Exceptions\MiddlewareNotFoundException;
use Omaressaouaf\PlainKit\Middleware\Guest;
use Omaressaouaf\PlainKit\Middleware\Middleware;

class MiddlewareTest extends TestCase
{
    public function test_it_throws_for_unknown_middleware_keys(): void
    {
        $this->bootApplication();

        $middleware = new Middleware();

        $this->expectException(MiddlewareNotFoundException::class);
        $this->expectExceptionMessage("middleware key not found => 'missing'");

        $middleware->resolve('missing');
    }

    public function test_guest_middleware_allows_unauthenticated_users(): void
    {
        $this->bootApplication();

        $guest = new Guest();

        $guest->handle();

        $this->assertTrue(true);
    }
}
