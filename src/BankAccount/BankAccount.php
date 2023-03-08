<?php
declare(strict_types=1);

namespace App\BankAccount;
class BankAccount implements BankAccountInterface
{
    public const DAILY_DEBIT_LIMIT = 3;
    private int $dailyDebitCounter = 0;

    public function __construct(
        private float $balance,
        private readonly string $currency
    ) {}

    public function getBalance(): float {
        return $this->balance;
    }

    public function setBalance(float $amount): self
    {
        $this->balance = $amount;
        return $this;
    }

    public function increaseDebitCounter(): void
    {
        $this->dailyDebitCounter++;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getDailyDebitCounter(): int
    {
        return $this->dailyDebitCounter;
    }
}


