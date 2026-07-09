<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Authenticator;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Http\Forms\LoginForm;

$request = App::resolve(Request::class);
$response = App::resolve(Response::class);
$authenticator = App::resolve(Authenticator::class);

$form = LoginForm::validate();

if (!$authenticator->attempt($request->input('email'), $request->input('password'))) {
    $form->addError("email", "Email or Password incorrect")->throw();
}

$response->redirect("/");
