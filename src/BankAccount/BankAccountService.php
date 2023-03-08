<?php
declare(strict_types=1);

namespace App\BankAccount;

use App\Transaction\Transaction;
use App\Transaction\TransactionInterface;
use App\Validators\TransactionValidatorInterface;
use Exception;

class BankAccountService implements BankAccountServiceInterface
{
    /**
     * @param TransactionInterface $transaction
     * @param BankAccountInterface $account
     * @param TransactionValidatorInterface $transactionValidator
     */
    public function __construct(
        private readonly TransactionInterface $transaction,
        private readonly BankAccountInterface $account,
        private readonly TransactionValidatorInterface $transactionValidator
    )
    {
        $this->transactionValidator
            ->setAccount($this->account)
            ->setTransaction($this->transaction)
        ;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function addCredit(): void
    {
        if (!$this->transactionValidator->isValid()) {
            throw new Exception($this->transactionValidator->getError());
        }

        $this->account->setBalance($this->account->getBalance() + $this->transaction->getAmount());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function addDebit(): void
    {
        if (!$this->transactionValidator->isValid()) {
            throw new Exception($this->transactionValidator->getError());
        }

        $updatedBalance = $this->account->getBalance() - ($this->transaction->getAmount() * Transaction::DEBIT_TRANSACTION_FEE);
        $this->account->setBalance($updatedBalance);
        $this->account->increaseDebitCounter();
    }
}
