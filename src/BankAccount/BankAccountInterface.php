<?php
declare(strict_types=1);

namespace App\BankAccount;

interface BankAccountInterface {
    /**
     * @return float
     */
    public function getBalance(): float;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @return int
     */
    public function getDailyDebitCounter(): int;

    /**
     * @return void
     */
    public function increaseDebitCounter(): void;
}
