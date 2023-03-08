<?php
declare(strict_types=1);

namespace App\Validators;

use App\BankAccount\BankAccount;
use App\BankAccount\BankAccountInterface;
use App\Transaction\Transaction;
use App\Transaction\TransactionInterface;
use App\Transaction\TransactionType;

class TransactionValidator implements TransactionValidatorInterface
{
    private const MESSAGE_INVALID_TRANSACTION_TYPE = 'Incorrect transaction type!';
    private const MESSAGE_NOT_SAME_CURRENCY = 'Account and transaction currencies not match!';
    private const MESSAGE_DAILY_DEBIT_LIMIT_REACHED = 'Daily debit limit reached!';
    private const MESSAGE_NOT_ENOUGH_BALANCE = 'Account balance is too low!';
    private const MESSAGE_UNKNOWN_ERROR = 'Unknown error occurred!';

    private ?string $error;
    private TransactionInterface $transaction;
    private BankAccountInterface $account;

    /**
     * @param TransactionInterface $transaction
     * @return self
     */
    public function setTransaction(TransactionInterface $transaction): self
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * @param BankAccountInterface $account
     * @return self
     */
    public function setAccount(BankAccountInterface $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function isValid(): bool
    {
        $this->error = self::MESSAGE_UNKNOWN_ERROR;
        return match ($this->transaction->getTransactionType()) {
            TransactionType::CREDIT => $this->canCredit(),
            TransactionType::DEBIT => $this->canDebit()
        };
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    private function canCredit(): bool
    {
        if ($this->transaction->getTransactionType() !== TransactionType::CREDIT) {
            $this->error = self::MESSAGE_INVALID_TRANSACTION_TYPE;
            return false;
        }
        if (!$this->isSameCurrency()) {
            $this->error = self::MESSAGE_NOT_SAME_CURRENCY;
            return false;
        }

        $this->error = null;
        return true;
    }

    /**
     * @return bool
     */
    private function canDebit(): bool
    {
        if ($this->transaction->getTransactionType() !== TransactionType::DEBIT) {
            $this->error = self::MESSAGE_INVALID_TRANSACTION_TYPE;
            return false;
        }
        if (!$this->isSameCurrency()) {
            $this->error = self::MESSAGE_NOT_SAME_CURRENCY;
            return false;
        }
        if ($this->isDailyDebitLimitReached()) {
            $this->error = self::MESSAGE_DAILY_DEBIT_LIMIT_REACHED;
            return false;
        }
        if (!$this->isBalanceEnoughToDebit()) {
            $this->error = self::MESSAGE_NOT_ENOUGH_BALANCE;
            return false;
        }

        $this->error = null;
        return true;
    }

    private function isSameCurrency(): bool
    {
        if ($this->account->getCurrency() !== $this->transaction->getCurrency()) {
            return false;
        }

        return true;
    }

    private function isDailyDebitLimitReached(): bool
    {
        return $this->account->getDailyDebitCounter() >= BankAccount::DAILY_DEBIT_LIMIT;
    }

    /**
     * @return bool
     */
    private function isBalanceEnoughToDebit(): bool
    {
        return $this->account->getBalance() > ($this->transaction->getAmount() * Transaction::DEBIT_TRANSACTION_FEE);
    }
}
