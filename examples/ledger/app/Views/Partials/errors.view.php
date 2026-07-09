<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Session;

$session = App::resolve(Session::class);

$errors = $session->get('errors');
?>

<?php if ($errors): ?>
    <br>
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>

    <?php endforeach; ?>
<?php endif; ?>
