<?php
declare(strict_types=1);

namespace App\Transaction;

class Transaction implements TransactionInterface
{
    public const DEBIT_TRANSACTION_FEE = 1.005;
    public function __construct(
        private readonly TransactionType $transactionType,
        private readonly float           $amount,
        private readonly string          $currency,
    )
    {}

    /**
     * @return TransactionType
     */
    public function getTransactionType(): TransactionType
    {
        return $this->transactionType;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}
