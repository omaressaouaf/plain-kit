<?php

namespace Http\Forms;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Form;
use Omaressaouaf\PlainKit\Validator;
use Repositories\ClientRepository;

class StoreTransactionForm extends Form
{
    protected function handle(): void
    {
        $typeValid = Validator::exists($this->request->input('type'))
            && Validator::in($this->request->input('type'), ['earning', 'expense']);
        if (!$typeValid) {
            $this->addError("name", "Type is required and must be either earning or expense");
        }

        $amountValid = Validator::exists($this->request->input('amount'))
            && Validator::min($this->request->input('amount'), 0.01)
            && Validator::numeric($this->request->input('amount'));
        if (!$amountValid) {
            $this->addError("name", "Amount is required, minimum is 0.01, it should be numeric");
        }

        $clientRepository = App::resolve(ClientRepository::class);

        $clientIdValid = Validator::exists($this->request->input('client_id'))
            && $clientRepository->existsById($this->request->input('client_id'));
        if (!$clientIdValid) {
            $this->addError("name", "Client ID is required, and must exists within the clients list");
        }
    }
}
