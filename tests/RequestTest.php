<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Request;

class RequestTest extends TestCase
{
    private Request $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();
    }

    public function test_it_reads_the_request_uri_path(): void
    {
        $_SERVER['REQUEST_URI'] = '/clients?page=2';

        $this->assertSame('/clients', $this->request->uri());
    }

    public function test_it_reads_the_absolute_uri(): void
    {
        $_SERVER['REQUEST_URI'] = '/reports?start=1';

        $this->assertSame('/reports?start=1', $this->request->abs_uri());
    }

    public function test_it_reads_the_request_method(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $this->assertSame('POST', $this->request->method());
    }

    public function test_it_reads_get_data(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET = ['name' => 'Acme'];

        $this->assertSame(['name' => 'Acme'], $this->request->data());
        $this->assertSame('Acme', $this->request->input('name'));
    }

    public function test_it_reads_post_data(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['email' => 'user@example.com'];

        $this->assertSame(['email' => 'user@example.com'], $this->request->data());
        $this->assertSame('user@example.com', $this->request->input('email'));
    }

    public function test_it_returns_default_input_when_key_is_missing(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->assertSame('default', $this->request->input('missing', 'default'));
    }

    public function test_it_reads_route_parameters(): void
    {
        $this->request->setParams(['id' => '42', 'slug' => 'acme']);

        $this->assertSame('42', $this->request->params('id'));
        $this->assertSame('acme', $this->request->params('slug'));
        $this->assertSame(['id' => '42', 'slug' => 'acme'], $this->request->params());
    }

    public function test_it_returns_default_when_route_parameter_is_missing(): void
    {
        $this->assertSame('fallback', $this->request->params('id', 'fallback'));
    }
}
