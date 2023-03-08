<?php
declare(strict_types=1);

namespace App\Transaction;

interface TransactionInterface
{
    public function getTransactionType(): TransactionType;
    public function getAmount(): float;
    public function getCurrency(): string;
}
