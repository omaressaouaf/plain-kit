<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Middleware;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;

class VerifyCsrf implements MiddlewareInterface
{
    private Request $request;

    private Response $response;

    private Csrf $csrf;

    public function __construct()
    {
        $this->request = App::resolve(Request::class);

        $this->response = App::resolve(Response::class);

        $this->csrf = App::resolve(Csrf::class);
    }

    public function handle(): void
    {
        if ($this->request->method() !== 'POST') {
            return;
        }

        $token = $this->request->input('_csrf_token');

        if (! $token || ! $this->csrf->verify($token)) {
            $this->response->abort(419);
        }
    }
}
