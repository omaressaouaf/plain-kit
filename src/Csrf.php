<?php


declare(strict_types=1);

namespace Omaressaouaf\PlainKit;

class Csrf
{
    private Session $session;

    public function __construct()
    {
        $this->session = App::resolve(Session::class);
    }

    public function generate(): string
    {
        if ($token = $this->session->get('_csrf_token')) {
            return $token;
        }

        $token = bin2hex(random_bytes(32));

        $this->session->put('_csrf_token', $token);

        return $token;
    }

    public function verify(string $token): bool
    {
        return hash_equals((string) $this->session->get('_csrf_token', ''), $token);
    }
}
