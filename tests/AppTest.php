<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Router;
use Omaressaouaf\PlainKit\Session;
use stdClass;

class AppTest extends TestCase
{
    public function test_it_boots_with_a_base_path(): void
    {
        $app = $this->bootApplication();

        $this->assertInstanceOf(App::class, $app);
        $this->assertStringEndsWith('/tests/fixtures/app/', PLAINKIT_BASE_PATH);
    }

    public function test_it_throws_when_base_path_is_empty(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('A base path is required to boot PlainKit.');

        App::create('');
    }

    public function test_it_registers_default_bindings(): void
    {
        $this->bootApplication();

        $this->assertInstanceOf(Session::class, App::resolve(Session::class));
        $this->assertInstanceOf(Request::class, App::resolve(Request::class));
        $this->assertInstanceOf(Router::class, App::resolve(Router::class));
        $this->assertInstanceOf(Csrf::class, App::resolve(Csrf::class));
    }

    public function test_it_registers_custom_bindings(): void
    {
        $this->bootApplication()
            ->bind('custom.service', fn () => new stdClass());

        $this->assertInstanceOf(stdClass::class, App::resolve('custom.service'));
    }

    public function test_base_path_helper_delegates_to_base_path_function(): void
    {
        $this->bootApplication();

        $this->assertSame(
            PLAINKIT_BASE_PATH . 'routes.php',
            App::basePath('routes.php')
        );
    }
}
