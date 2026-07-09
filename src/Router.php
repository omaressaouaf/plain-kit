<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit;

use Omaressaouaf\PlainKit\Exceptions\ValidationException;
use Omaressaouaf\PlainKit\Middleware\Middleware;

class Router
{
    private array $routes = [];

    private Request $request;

    private Response $response;

    private Session $session;

    private Middleware $middleware;

    public function __construct()
    {
        $this->request = App::resolve(Request::class);

        $this->response = App::resolve(Response::class);

        $this->session = App::resolve(Session::class);

        $this->middleware = App::resolve(Middleware::class);
    }

    public function add(string $method, string $uri, string $controller): self
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'pattern' => $this->compileUri($uri),
            'controller' => $controller,
            'middleware' => null,
        ];

        return $this;
    }

    public function get(string $uri, string $controller): self
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): self
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete(string $uri, string $controller): self
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch(string $uri, string $controller): self
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put(string $uri, string $controller): self
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function middleware(string $middlewareKey): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middlewareKey;

        return $this;
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            if (! preg_match($route['pattern'], $uri, $matches)) {
                continue;
            }

            $params = [];

            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $params[$key] = $value;
                }
            }

            $this->request->setParams($params);
            App::container()->bind(Request::class, fn () => $this->request);

            $this->middleware->resolve('csrf');

            if ($route['middleware']) {
                $this->middleware->resolve($route['middleware']);
            }

            return require app_path('Http/Controllers/' . $route['controller'] . '.php');
        }

        $this->response->abort();
    }

    public function handleRequest(): void
    {
        $method = $_POST['_method'] ?? $this->request->method();

        try {
            $this->route($this->request->uri(), $method);
        } catch (ValidationException $exception) {
            $this->session->flash('errors', $exception->errors);
            $this->session->flash('old', $exception->old);

            $this->response->back();
        }

        $this->session->unflash();
    }

    private function compileUri(string $uri): string
    {
        if ($uri === '/') {
            return '#^/$#';
        }

        $segments = explode('/', trim($uri, '/'));
        $parts = [];

        foreach ($segments as $segment) {
            if (preg_match('/^\{([a-zA-Z_][a-zA-Z0-9_]*)\}$/', $segment, $matches)) {
                $parts[] = '(?P<' . $matches[1] . '>[^/]+)';
                continue;
            }

            $parts[] = preg_quote($segment, '#');
        }

        return '#^/' . implode('/', $parts) . '$#';
    }
}
