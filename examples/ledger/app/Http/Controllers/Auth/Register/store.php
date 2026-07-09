<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Session;
use Http\Forms\RegisterForm;
use Services\RegisterService;

$request = App::resolve(Request::class);
$response = App::resolve(Response::class);
$session = App::resolve(Session::class);
$registerService = App::resolve(RegisterService::class);

$form = RegisterForm::validate();

if (!$registerService->register($request->input('name'), $request->input('email'), $request->input('password'))) {
    $form->addError("email", "Email already exists")->throw();
}

$session->flash('success', 'Registered successfully!');

$response->redirect("/login");
