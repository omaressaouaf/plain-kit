<?php


declare(strict_types=1);

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Response;

$response = App::resolve(Response::class);
?>

<?php $response->view('Partials/head') ?>
<?php $response->view('Partials/nav') ?>

<p>401, Not Authorized!</p>

<?php $response->view('Partials/footer') ?>
