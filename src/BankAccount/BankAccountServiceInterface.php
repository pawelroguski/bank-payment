<?php
declare(strict_types=1);

namespace App\BankAccount;

interface BankAccountServiceInterface
{
    public function addCredit(): void;
    public function addDebit(): void;

}
