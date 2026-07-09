<?php

namespace Http\Forms;

use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Validator;

class RegisterForm extends Form
{
    protected function handle(): void
    {
        if (!Validator::exists($this->request->input('name'))) {
            $this->addError("name", "Name is required");
        }

        $emailValid = Validator::exists($this->request->input('email')) && Validator::email($this->request->input('email'));
        if (!$emailValid) {
            $this->addError("email", "Email must be valid");
        }

        $passwordValid = Validator::exists($this->request->input('password')) &&
            Validator::min($this->request->input('password'), 8);
        if (!$passwordValid) {
            $this->addError("password", "Password is required to be at least 8 characters");
        }
    }
}
