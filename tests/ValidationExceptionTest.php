<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Exceptions\ValidationException;

class ValidationExceptionTest extends TestCase
{
    public function test_it_carries_validation_errors_and_old_input(): void
    {
        $errors = ['email' => 'Email is required'];
        $old = ['email' => ''];

        try {
            ValidationException::throw($errors, $old);
            $this->fail('Expected ValidationException was not thrown.');
        } catch (ValidationException $exception) {
            $this->assertSame($errors, $exception->errors);
            $this->assertSame($old, $exception->old);
        }
    }
}
