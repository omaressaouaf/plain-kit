<?php

namespace Omaressaouaf\PlainKit\Middleware;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Session;

class Auth
{
    private Response $response;

    private Session $session;

    public function __construct()
    {
        $this->response = App::resolve(Response::class);

        $this->session = App::resolve(Session::class);
    }

    public function handle(): void
    {
        if (! $this->session->has("user")) {
            $this->response->redirect("/login");
        }
    }
}
