<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Router;

class RouterTest extends TestCase
{
    public function test_it_dispatches_a_matching_get_route(): void
    {
        $this->bootApplication();

        $router = new Router();
        $router->get('/ping', 'ping');

        $result = $router->route('/ping', 'GET');

        $this->assertSame('pong', $result);
    }

    public function test_it_supports_fluent_middleware_registration(): void
    {
        $this->bootApplication();

        $router = new Router();
        $route = $router->get('/guest-only', 'ping')->middleware('guest');

        $this->assertSame($router, $route);
        $this->assertSame('pong', $router->route('/guest-only', 'GET'));
    }

    public function test_handle_request_honors_post_method_override(): void
    {
        $this->bootApplication();

        $csrf = new Csrf();
        $token = $csrf->generate();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/logout';
        $_POST = ['_method' => 'DELETE', '_csrf_token' => $token];

        $router = new Router();
        $router->delete('/logout', 'mark');

        $router->handleRequest();

        $this->assertSame('deleted', $GLOBALS['router_test_marker'] ?? null);
    }
}
