<?php

namespace Http\Forms;

use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Validator;

class LoginForm extends Form
{
    protected function handle(): void
    {
        $emailValid = Validator::exists($this->request->input('email')) && Validator::email($this->request->input('email'));
        if (!$emailValid) {
            $this->addError("email", "Email must be valid");
        }

        if (!Validator::exists($this->request->input('password'))) {
            $this->addError("password", "Password is required");
        }
    }
}
