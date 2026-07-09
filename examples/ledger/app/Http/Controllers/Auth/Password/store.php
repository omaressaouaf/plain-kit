<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Authenticator;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Session;
use Http\Forms\PasswordForm;

$request = App::resolve(Request::class);
$response = App::resolve(Response::class);
$session = App::resolve(Session::class);
$authenticator = App::resolve(Authenticator::class);

$form = PasswordForm::validate();

$authenticator->updatePassword($request->input('password'));

$session->flash('success', 'Password is updated');

$response->back();
