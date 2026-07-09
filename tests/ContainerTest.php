<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Container;
use Omaressaouaf\PlainKit\Exceptions\BindingNotFoundException;
use stdClass;

class ContainerTest extends TestCase
{
    public function test_it_resolves_a_bound_class(): void
    {
        $container = new Container();

        $container->bind(stdClass::class, fn () => new stdClass());

        $this->assertInstanceOf(stdClass::class, $container->resolve(stdClass::class));
    }

    public function test_it_returns_a_new_instance_on_each_resolve(): void
    {
        $container = new Container();

        $container->bind(stdClass::class, fn () => new stdClass());

        $first = $container->resolve(stdClass::class);
        $second = $container->resolve(stdClass::class);

        $this->assertNotSame($first, $second);
    }

    public function test_it_throws_when_binding_is_missing(): void
    {
        $container = new Container();

        $this->expectException(BindingNotFoundException::class);
        $this->expectExceptionMessage('MissingService binding key not found');

        $container->resolve('MissingService');
    }
}
