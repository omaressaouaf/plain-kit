<?php


declare(strict_types=1);

namespace Services;

use Omaressaouaf\PlainKit\App;
use Repositories\TransactionRepository;

class TransactionService
{
    private TransactionRepository $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = App::resolve(TransactionRepository::class);
    }

    public function get(): array
    {
        return $this->transactionRepository->get();
    }

    public function getReports(?string $startDate = null, ?string $endDate = null): array
    {
        return $this->transactionRepository->getReports($startDate, $endDate);
    }

    public function create(string $type, float $amount, int $clientId): void
    {
        $this->transactionRepository->create($type, $amount, $clientId);
    }
}
