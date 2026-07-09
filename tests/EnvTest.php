<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

class EnvTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        foreach (['APP_NAME', 'DB_HOST', 'DB_PORT', 'QUOTED_VALUE', 'COMMENTED_OUT', 'APP_ENV'] as $key) {
            unset($_ENV[$key], $_SERVER[$key]);
            putenv($key);
        }
    }

    public function test_load_env_reads_variables_from_an_env_file(): void
    {
        load_env($this->fixturesPath());

        $this->assertSame('PlainKit Test', env('APP_NAME'));
        $this->assertSame('127.0.0.1', env('DB_HOST'));
        $this->assertSame('3307', env('DB_PORT'));
    }

    public function test_load_env_ignores_comments_and_blank_lines(): void
    {
        load_env($this->fixturesPath());

        $this->assertNull(env('COMMENTED_OUT'));
    }

    public function test_load_env_strips_surrounding_quotes(): void
    {
        load_env($this->fixturesPath());

        $this->assertSame('quoted value', env('QUOTED_VALUE'));
    }

    public function test_env_returns_default_when_key_is_missing(): void
    {
        $this->assertSame('fallback', env('MISSING_KEY', 'fallback'));
    }

    public function test_env_reads_values_from_the_environment(): void
    {
        $_ENV['APP_ENV'] = 'testing';

        $this->assertSame('testing', env('APP_ENV'));
        $this->assertSame('local', env('UNKNOWN', 'local'));
    }

    public function test_load_env_does_nothing_when_env_file_is_missing(): void
    {
        load_env($this->fixturesPath() . '/missing');

        $this->assertNull(env('APP_NAME'));
    }
}
