<?php

namespace Http\Forms;

use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Validator;

class StoreClientForm extends Form
{
    protected function handle(): void
    {
        if (!Validator::exists($this->request->input('name'))) {
            $this->addError("name", "Name is required");
        }
    }
}
