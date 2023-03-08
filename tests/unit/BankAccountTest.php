<?php
declare(strict_types=1);

use App\BankAccount\BankAccount;
use App\BankAccount\BankAccountInterface;
use App\BankAccount\BankAccountService;
use App\Transaction\TransactionInterface;
use App\Validators\TransactionValidator;
use App\Validators\TransactionValidatorInterface;
use PHPUnit\Framework\TestCase;
use App\Transaction\Transaction;
use App\Transaction\TransactionType;

class BankAccountTest extends TestCase
{
    private BankAccountInterface $account;

    public function setUp(): void
    {
        $this->account = new BankAccount(1000, 'USD');
    }

    public function test_account_has_balance()
    {
        $this->assertEquals(1000, $this->account->getBalance());
    }

    public function test_account_has_currency()
    {
        $this->assertEquals('USD', $this->account->getCurrency());
    }

    public function test_account_has_daily_debit_transactions_limit()
    {
        $this->assertEquals(3, $this->account::DAILY_DEBIT_LIMIT);
    }

    public function test_account_has_daily_debit_transactions_counter()
    {
        $this->account->increaseDebitCounter();
        $this->assertEquals(1, $this->account->getDailyDebitCounter());
    }
}
