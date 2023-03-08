<?php
declare(strict_types=1);

namespace App\BankAccount;

interface BankAccountInterface {
    public function getBalance(): float;
    public function getCurrency(): string;
    public function getDailyDebitCounter(): int;
    public function increaseDebitCounter(): void;
}
