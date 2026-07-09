<?php

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Csrf;
use Omaressaouaf\PlainKit\Request;
use Omaressaouaf\PlainKit\Response;
use Omaressaouaf\PlainKit\Session;

$request = App::resolve(Request::class);
$response = App::resolve(Response::class);
$csrf = App::resolve(Csrf::class);
$session = App::resolve(Session::class);

$old = $session->get('old');
?>

<?php $response->view('Partials/head') ?>
<?php $response->view('Partials/nav') ?>

<h4 class="mb-4">List of Reports</h4>

<form method="GET" class="mb-5">
    <div class="mb-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="datetime-local" name="start_date" class="form-control" value="<?= _r($request->input('start_date')) ?>" required>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">End Date</label>
        <input type="datetime-local" name="end_date" class="form-control" value="<?= _r($request->input('end_date')) ?>" required>
    </div>
    <button type="submit" class="btn btn-dark btn-sm">Filter</button>
</form>

<?php if (!empty($reports)): ?>
    <?php foreach ($reports as $report): ?>
        <div>
            <h2>Client: <?= _r($report['client_name']) ?></h2>
            <p><strong>Total Earnings:</strong> <?= number_format($report['total_earnings'], 2) ?> USD</p>
            <p><strong>Total Expenses:</strong> <?= number_format($report['total_expenses'], 2) ?> USD</p>
            <p><strong>Net Balance:</strong>
                <span class="<?= $report['balance'] >= 0 ? 'text-success' : 'text-danger' ?>">
                    <?= ($report['balance'] >= 0 ? '+' : '') . number_format($report['balance'], 2) ?> USD
                </span>
            </p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No transactions found for the selected period.</p>
<?php endif; ?>

<?php $response->view('Partials/footer') ?>
