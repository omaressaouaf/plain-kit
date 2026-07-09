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
            "method" => $method,
            "uri" => $uri,
            "controller" => $controller,
            "middleware" => null
        ];

        return $this;
    }

    public function get(string $uri, string $controller): self
    {
        return $this->add("GET", $uri, $controller);
    }

    public function post(string $uri, string $controller): self
    {
        return $this->add("POST", $uri, $controller);
    }

    public function delete(string $uri, string $controller): self
    {
        return $this->add("DELETE", $uri, $controller);
    }

    public function patch(string $uri, string $controller): self
    {
        return $this->add("PATCH", $uri, $controller);
    }

    public function put(string $uri, string $controller): self
    {
        return $this->add("PUT", $uri, $controller);
    }

    public function middleware(string $middlewareKey): self
    {
        $this->routes[array_key_last($this->routes)]["middleware"] = $middlewareKey;

        return $this;
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route["uri"] === $uri && $route["method"] === strtoupper($method)) {
                $this->middleware->resolve('csrf');

                if ($route["middleware"]) {
                    $this->middleware->resolve($route['middleware']);
                }

                return require app_path("Http/Controllers/" . $route["controller"] . '.php');
            }
        }

        $this->response->abort();
    }

    public function handleRequest(): void
    {
        $method = $_POST["_method"] ?? $this->request->method();

        try {
            $this->route($this->request->uri(), $method);
        } catch (ValidationException $exception) {
            $this->session->flash("errors", $exception->errors);
            $this->session->flash("old", $exception->old);

            $this->response->back();
        }

        $this->session->unflash();
    }
}
