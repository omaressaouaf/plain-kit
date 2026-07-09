<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Session;

$response = App::resolve(Response::class);
$csrf = App::resolve(Csrf::class);
$session = App::resolve(Session::class);

$old = $session->get('old');
?>

<?php $response->view('Partials/head') ?>
<?php $response->view('Partials/nav') ?>

<form action="/register" method="POST">
    <?php $response->view('Partials/errors') ?>
    <input type="hidden" name="_csrf_token" value="<?= $csrf->generate() ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value=<?= $old["name"] ?? "" ?>>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email" value=<?= $old["email"] ?? "" ?>>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" value=<?= $old["password"] ?? "" ?>>
    </div>
    <button type="submit" class="btn btn-dark btn-sm">Register</button>
</form>

<?php $response->view('Partials/footer') ?>
