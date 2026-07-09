<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Authenticator;
use Omaressaouaf\PlainKit\Response;

$response = App::resolve(Response::class);
$authenticator = App::resolve(Authenticator::class);
?>

<?php $response->view('Partials/head') ?>
<?php $response->view('Partials/nav') ?>

<p>Welcome Home <?= _r($authenticator->user()['name']) ?>!</p>

<?php $response->view('Partials/footer') ?>
