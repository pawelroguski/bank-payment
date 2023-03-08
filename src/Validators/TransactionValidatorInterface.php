<?php
declare(strict_types=1);

namespace App\Validators;

use App\BankAccount\BankAccountInterface;
use App\Transaction\TransactionInterface;

interface TransactionValidatorInterface
{
    /**
     * @param BankAccountInterface $account
     * @return self
     */
    public function setAccount(BankAccountInterface $account): self;

    /**
     * @param TransactionInterface $transaction
     * @return self
     */
    public function setTransaction(TransactionInterface $transaction): self;

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return string
     */
    public function getError(): string;
}
