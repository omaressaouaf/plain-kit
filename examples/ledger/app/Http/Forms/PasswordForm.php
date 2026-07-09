<?php


declare(strict_types=1);

namespace Http\Forms;

use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Validator;

class PasswordForm extends Form
{
    protected function handle(): void
    {
        if (!Validator::exists($this->request->input('password'))) {
            $this->addError("password", "Password is required");
        }
    }
}
