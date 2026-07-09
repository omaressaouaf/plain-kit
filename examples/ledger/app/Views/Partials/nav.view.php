<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Authenticator;
use Omaressaouaf\PlainKit\Csrf;

$authenticator = App::resolve(Authenticator::class);
$csrf = App::resolve(Csrf::class);
?>

<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/" class="nav-link px-2 link-dark">Home</a></li>
        <li><a href="/clients" class="nav-link px-2 link-dark">Clients</a></li>
        <li><a href="/transactions" class="nav-link px-2 link-dark">Transactions</a></li>
        <li><a href="/reports" class="nav-link px-2 link-dark">Reports</a></li>
    </ul>

    <div class="col-md-3 text-end">
        <?php if ($authenticator->check()): ?>
            <form action="/logout" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_csrf_token" value="<?= $csrf->generate() ?>">
                <button type="submit" class="btn btn-dark btn-sm me-2">Log Out</button>
            </form>
        <?php else: ?>
            <a href="/login" class="btn btn-dark btn-sm">Login</a>
            <a href="/register" class="btn btn-dark btn-sm">Register</a>
        <?php endif ?>
    </div>
</header>
