<?php
declare(strict_types=1);

namespace App\BankAccount;
class BankAccount implements BankAccountInterface
{
   public const DAILY_DEBIT_LIMIT = 3;

    /**
     * @var int
     */
    private int $dailyDebitCounter = 0;

    /**
     * @param float $balance
     * @param string $currency
     */
    public function __construct(
        private float $balance,
        private readonly string $currency
    ) {}

    /**
     * @return float
     */
    public function getBalance(): float {
        return $this->balance;
    }

    /**
     * @param float $amount
     * @return self
     */
    public function setBalance(float $amount): self
    {
        $this->balance = $amount;
        return $this;
    }

    /**
     * @return void
     */
    public function increaseDebitCounter(): void
    {
        $this->dailyDebitCounter++;
    }

    /**
     * @return string
     */
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


