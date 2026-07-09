<?php

namespace Omaressaouaf\PlainKit;

use Omaressaouaf\PlainKit\Middleware\Middleware;

class App
{
    protected static Container $container;

    private function __construct(string $basePath)
    {
        if (! defined('PLAINKIT_BASE_PATH')) {
            define('PLAINKIT_BASE_PATH', rtrim($basePath, '/') . '/');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        static::$container = new Container();

        $this->registerDefaultBindings();
    }

    public static function create(string $basePath): self
    {
        return new self($basePath);
    }

    public function bind(string $abstract, callable $concrete): self
    {
        static::$container->bind($abstract, $concrete);

        return $this;
    }

    public static function resolve(string $key): mixed
    {
        return static::$container->resolve($key);
    }

    public function run(string $routesFile = 'routes.php'): void
    {
        $router = static::resolve(Router::class);

        require base_path($routesFile);

        $router->handleRequest();
    }

    private function registerDefaultBindings(): void
    {
        $this->bind(Session::class, fn() => new Session());
        $this->bind(Csrf::class, fn() => new Csrf());
        $this->bind(Middleware::class, fn() => new Middleware());
        $this->bind(Request::class, fn() => new Request());
        $this->bind(Response::class, fn() => new Response());
        $this->bind(Router::class, fn() => new Router());
        $this->bind(Database::class, fn() => new Database());
        $this->bind(Authenticator::class, fn() => new Authenticator());
    }
}
