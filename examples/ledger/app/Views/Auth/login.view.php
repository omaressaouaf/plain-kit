<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Response;

$response = App::resolve(Response::class);
$csrf = App::resolve(Csrf::class);
?>

<?php $response->view('Partials/head') ?>
<?php $response->view('Partials/nav') ?>

<form action="/login" method="POST">
    <?php $response->view('Partials/success') ?>
    <?php $response->view('Partials/errors') ?>
    <input type="hidden" name="_csrf_token" value="<?= $csrf->generate() ?>">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-dark btn-sm">Login</button>
</form>

<?php $response->view('Partials/footer') ?>
