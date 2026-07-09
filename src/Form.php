<?php


declare(strict_types=1);

namespace Omaressaouaf\PlainKit;

use Omaressaouaf\PlainKit\Exceptions\ValidationException;

abstract class Form
{
    protected Request $request;

    protected array $errors = [];

    public function __construct()
    {
        $this->request = App::resolve(Request::class);
    }

    public static function validate()
    {
        $form = new static();

        $form->handle();

        return $form->failed() ? $form->throw() : $form;
    }

    public function failed(): bool
    {
        return (bool) count(array_keys($this->errors));
    }

    public function throw(): void
    {
        ValidationException::throw($this->errors, $this->request->data());
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function addError(string $name, string $content): self
    {
        $this->errors[$name] = $content;

        return $this;
    }

    abstract protected function handle(): void;
}
