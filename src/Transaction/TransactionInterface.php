<?php
declare(strict_types=1);

namespace App\Transaction;

interface TransactionInterface
{
    /**
     * @return TransactionType
     */
    public function getTransactionType(): TransactionType;

    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @return string
     */
    public function getCurrency(): string;
}
