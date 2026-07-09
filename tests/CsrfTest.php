<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Csrf;

class CsrfTest extends TestCase
{
    public function test_it_generates_a_token(): void
    {
        $this->bootApplication();

        $csrf = new Csrf();
        $token = $csrf->generate();

        $this->assertSame(64, strlen($token));
        $this->assertMatchesRegularExpression('/^[a-f0-9]{64}$/', $token);
    }

    public function test_it_reuses_the_same_token_within_a_session(): void
    {
        $this->bootApplication();

        $csrf = new Csrf();
        $first = $csrf->generate();
        $second = $csrf->generate();

        $this->assertSame($first, $second);
    }

    public function test_it_verifies_a_valid_token(): void
    {
        $this->bootApplication();

        $csrf = new Csrf();
        $token = $csrf->generate();

        $this->assertTrue($csrf->verify($token));
    }

    public function test_it_rejects_an_invalid_token(): void
    {
        $this->bootApplication();

        $csrf = new Csrf();
        $csrf->generate();

        $this->assertFalse($csrf->verify('invalid-token'));
    }
}
