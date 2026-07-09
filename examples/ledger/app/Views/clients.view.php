<?php


declare(strict_types=1);

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

<h4 class="mb-4">Create client</h4>
<form action="/clients" method="POST" class="mb-5">
    <?php $response->view('Partials/success') ?>
    <?php $response->view('Partials/errors') ?>
    <input type="hidden" name="_csrf_token" value="<?= $csrf->generate() ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value=<?= $old["name"] ?? "" ?>>
    </div>
    <button type="submit" class="btn btn-dark btn-sm">Create</button>
</form>

<h4 class="mb-4">List of Clients</h4>
<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($clients) > 0): ?>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= e($client['id']) ?></td>
                    <td><?= e($client['name']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">No clients found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $response->view('Partials/footer') ?>
