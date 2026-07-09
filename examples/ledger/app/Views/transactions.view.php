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

<h4 class="mb-4">Create Transaction</h4>
<form action="/transactions" method="POST" class="mb-5">
    <?php $response->view('Partials/success') ?>
    <?php $response->view('Partials/errors') ?>
    <input type="hidden" name="_csrf_token" value="<?= $csrf->generate() ?>">

    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select name="type" id="type" class="form-control">
            <option value="earning" <?= (isset($old['type']) && $old['type'] === 'earning') ? 'selected' : '' ?>>Earning</option>
            <option value="expense" <?= (isset($old['type']) && $old['type'] === 'expense') ? 'selected' : '' ?>>Expense</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="text" step="0.01" class="form-control" id="amount" name="amount" value="<?= $old["amount"] ?? "" ?>">
    </div>

    <div class="mb-3">
        <label for="client_id" class="form-label">Client</label>
        <select name="client_id" id="client_id" class="form-control">
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client['id'] ?>" <?= (isset($old['client_id']) && $old['client_id'] == $client['id']) ? 'selected' : '' ?>>
                    <?= e($client['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-dark btn-sm">Create</button>
</form>

<h4 class="mb-4">List of Transactions</h4>
<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Client</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($transactions) > 0): ?>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= e($transaction['id']) ?></td>
                    <td><?= e(ucfirst($transaction['type'])) ?></td>
                    <td><?= e(number_format((float) $transaction['amount'], 2)) ?></td>
                    <td><?= e($transaction['client_name']) ?></td>
                    <td><?= e($transaction['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No transactions found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $response->view('Partials/footer') ?>
