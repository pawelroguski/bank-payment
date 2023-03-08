<?php
declare(strict_types=1);

namespace App\Validators;

use App\BankAccount\BankAccountInterface;
use App\Transaction\TransactionInterface;

interface TransactionValidatorInterface
{
    public function setAccount(BankAccountInterface $account): self;
    public function setTransaction(TransactionInterface $transaction): self;
    public function isValid(): bool;
    public function getError(): string;
}
