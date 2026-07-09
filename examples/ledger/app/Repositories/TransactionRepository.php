<?php


declare(strict_types=1);

namespace Repositories;

use Omaressaouaf\PlainKit\App;
use Omaressaouaf\PlainKit\Database;

class TransactionRepository
{
    private Database $database;

    public function __construct()
    {
        $this->database = App::resolve(Database::class);
    }

    public function get(): array
    {
        return $this->database
            ->query('SELECT transactions.*, clients.name as client_name
                    FROM transactions
                    JOIN clients ON transactions.client_id = clients.id
                    ORDER BY ID DESC
            ')
            ->get();
    }

    public function getReports(?string $startDate = null, ?string $endDate = null): array
    {
        $dateRangeFilter = $startDate && $endDate
            ? 'WHERE transactions.created_at BETWEEN :startDate AND :endDate'
            : '';

        $params = $dateRangeFilter ? ['startDate' => $startDate, 'endDate' => $endDate,] : [];

        return $this->database
            ->query(
                "SELECT
                    clients.name AS client_name,
                    SUM(CASE WHEN transactions.type = 'earning' THEN transactions.amount ELSE 0 END) AS total_earnings,
                    SUM(CASE WHEN transactions.type = 'expense' THEN transactions.amount ELSE 0 END) AS total_expenses,
                    SUM(CASE
                        WHEN transactions.type = 'earning' THEN transactions.amount
                        WHEN transactions.type = 'expense' THEN -transactions.amount
                        ELSE 0
                    END) AS balance
                FROM transactions
                JOIN clients ON transactions.client_id = clients.id
                $dateRangeFilter
                GROUP BY clients.name
        ",
                $params
            )
            ->get();
    }

    public function create(string $type, float $amount, int $clientId): void
    {
        $this->database->query(
            'INSERT INTO transactions(type, amount, client_id) VALUES(:type, :amount, :client_id)',
            [
                'type' => $type,
                'amount' => $amount,
                'client_id' => $clientId,
            ]
        );
    }
}
