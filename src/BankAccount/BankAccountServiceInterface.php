<?php
declare(strict_types=1);

namespace App\BankAccount;

interface BankAccountServiceInterface
{
    /**
     * @return void
     */
    public function addCredit(): void;

    /**
     * @return void
     */
    public function addDebit(): void;

}
