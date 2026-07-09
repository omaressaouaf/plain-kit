<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Response;

class ResponseTest extends TestCase
{
    public function test_it_outputs_json(): void
    {
        $response = new Response();

        ob_start();
        $response->json(['status' => 'ok', 'count' => 2]);
        $output = ob_get_clean();

        $this->assertSame('{"status":"ok","count":2}', $output);
    }

    public function test_it_renders_a_view_with_context(): void
    {
        $this->bootApplication();

        $response = new Response();

        ob_start();
        $response->view('greeting', ['name' => 'PlainKit']);
        $output = ob_get_clean();

        $this->assertStringContainsString('Hello, PlainKit!', $output);
        $this->assertStringNotContainsString('<script>', $output);
    }
}
