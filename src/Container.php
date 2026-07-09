<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit;

use Omaressaouaf\PlainKit\Exceptions\BindingNotFoundException;

class Container
{
    protected array $bindings = [];

    public function bind(string $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve(string $key): mixed
    {
        if (! array_key_exists($key, $this->bindings)) {
            throw new BindingNotFoundException("{$key} binding key not found");
        }

        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}
