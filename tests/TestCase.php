<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\App;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! defined('PLAINKIT_BASE_PATH')) {
            define('PLAINKIT_BASE_PATH', $this->fixturesPath() . '/');
        }

        $_SESSION = [];
        $_GET = [];
        $_POST = [];
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        unset($_SERVER['HTTP_REFERER']);
    }

    protected function bootApplication(): App
    {
        return App::create($this->fixturesPath());
    }

    protected function fixturesPath(): string
    {
        return dirname(__DIR__) . '/tests/fixtures/app';
    }
}
