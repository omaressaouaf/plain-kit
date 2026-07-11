<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Session;

class SessionTest extends TestCase
{
    private Session $session;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = new Session();
    }

    public function test_it_puts_and_gets_values(): void
    {
        $this->session->put('name', 'Omar');

        $this->assertSame('Omar', $this->session->get('name'));
    }

    public function test_it_returns_default_when_key_is_missing(): void
    {
        $this->assertSame('fallback', $this->session->get('missing', 'fallback'));
    }

    public function test_it_checks_if_a_key_exists(): void
    {
        $this->session->put('user', ['id' => 1]);
        $this->session->put('count', 0);
        $this->session->put('flag', false);

        $this->assertTrue($this->session->has('user'));
        $this->assertTrue($this->session->has('count'));
        $this->assertTrue($this->session->has('flag'));
        $this->assertFalse($this->session->has('missing'));
    }

    public function test_it_forgets_values(): void
    {
        $this->session->put('token', 'abc');
        $this->session->forget('token');

        $this->assertNull($this->session->get('token'));
        $this->assertFalse($this->session->has('token'));
    }

    public function test_it_flashes_and_reads_flash_data(): void
    {
        $this->session->flash('success', 'Saved');

        $this->assertSame('Saved', $this->session->get('success'));
    }

    public function test_flash_data_takes_priority_over_regular_session_data(): void
    {
        $this->session->put('message', 'old');
        $this->session->flash('message', 'new');

        $this->assertSame('new', $this->session->get('message'));
    }

    public function test_it_unflashes_data(): void
    {
        $this->session->flash('errors', ['name' => 'Required']);
        $this->session->unflash();

        $this->assertNull($this->session->get('errors'));
    }
}
