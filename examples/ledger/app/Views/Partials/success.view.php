<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Session;

$session = App::resolve(Session::class);
?>

<?php if ($session->has('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= $session->get('success') ?>
    </div>
<?php endif; ?>
