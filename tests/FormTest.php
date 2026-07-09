<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

use Omaressaouaf\PlainKit\Exceptions\ValidationException;
use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Validator;

class ExampleForm extends Form
{
    protected function handle(): void
    {
        if (! Validator::exists($this->request->input('email'))) {
            $this->addError('email', 'Email is required');
        }
    }
}

class FormTest extends TestCase
{
    public function test_it_passes_validation_when_input_is_valid(): void
    {
        $this->bootApplication();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['email' => 'user@example.com'];

        $form = ExampleForm::validate();

        $this->assertInstanceOf(ExampleForm::class, $form);
        $this->assertFalse($form->failed());
        $this->assertSame([], $form->errors());
    }

    public function test_it_throws_when_validation_fails(): void
    {
        $this->bootApplication();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['email' => ''];

        try {
            ExampleForm::validate();
            $this->fail('Expected ValidationException was not thrown.');
        } catch (ValidationException $exception) {
            $this->assertSame(['email' => 'Email is required'], $exception->errors);
            $this->assertSame(['email' => ''], $exception->old);
        }
    }
}
