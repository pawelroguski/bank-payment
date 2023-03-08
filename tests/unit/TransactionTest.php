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

class TransactionTest extends TestCase {

    private BankAccountInterface $account;
    private TransactionInterface $creditTransaction;
    private TransactionInterface $debitTransaction;
    private TransactionValidatorInterface $transactionValidator;
    public function setUp(): void
    {
        $this->account = new BankAccount(1000, 'USD');
        $this->transactionValidator = new TransactionValidator();
        $this->creditTransaction = new Transaction(TransactionType::CREDIT, 100, 'USD');
        $this->debitTransaction = new Transaction(TransactionType::DEBIT, 100, 'USD');
    }

    public function test_Account_balance_increased_when_AddCredit_action_inoked()
    {
        $service = new BankAccountService($this->creditTransaction, $this->account, $this->transactionValidator);
        $service->addCredit();
        $this->assertEquals(1100, $this->account->getBalance());
    }

    public function test_Account_balance_increased_correctly_when_AddCredit_action_multiple_times_inoked()
    {
        $service = new BankAccountService($this->creditTransaction, $this->account, $this->transactionValidator);
        $service->addCredit();
        $service->addCredit();
        $service->addCredit();
        $this->assertEquals(1300, $this->account->getBalance());
    }

    public function test_Account_balance_decreased_when_AddDebit_action_invoked()
    {
        $service = new BankAccountService($this->debitTransaction, $this->account, $this->transactionValidator);
        $service->addDebit();
        $this->assertEquals(899.5, $this->account->getBalance());
    }

    public function test_AddDebit_action_thrown_error_when_daily_debit_limit_exceeded()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Daily debit limit reached!');

        $service = new BankAccountService($this->debitTransaction, $this->account, $this->transactionValidator);
        $service->addDebit();
        $service->addDebit();
        $service->addDebit();
        $service->addDebit();
    }

    public function test_AddDebit_action_thrown_error_when_transaction_and_account_have_different_currencies_set_up()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Account and transaction currencies not match!');

        $transaction = new Transaction(TransactionType::DEBIT, 100, 'EUR');
        $service = new BankAccountService($transaction, $this->account, $this->transactionValidator);
        $service->addDebit();
    }

    public function test_AddCredit_action_thrown_error_when_transaction_and_account_have_different_currencies_set_up()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Account and transaction currencies not match!');

        $transaction = new Transaction(TransactionType::CREDIT, 100, 'EUR');
        $service = new BankAccountService($transaction, $this->account, $this->transactionValidator);
        $service->addCredit();
    }

    public function test_AddDebit_action_thrown_error_when_lower_account_balance_than_debit_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Account balance is too low!');

        $transaction = new Transaction(TransactionType::DEBIT, 996, 'USD');
        $service = new BankAccountService($transaction, $this->account, $this->transactionValidator);
        $service->addDebit();
    }
}

//class BankAccountTest extends TestCase {
//    public function testCanDebit() {
//        $account = new BankAccount(100, 'USD');
//        $payment = new Payment(50, 'USD');
//        $this->assertTrue($account->canDebit($payment->getAmount()));
//    }
//
//    public function testCannotDebitOverDailyLimit() {
//        $account = new BankAccount(100, 'USD');
//        $payment = new Transaction(TransactionType::DEBIT, 50, 'USD');
//        $account->debit($payment->getAmount());
//        $account->debit($payment->getAmount());
//        $account->debit($payment->getAmount());
//        $this->assertFalse($account->canDebit($payment->getAmount()));
//    }
//
//    public function testCannotDebitOverAvailableFunds() {
//        $account = new BankAccount(100, 'USD');
//        $payment = new Payment(200, 'USD');
//        $this->assertFalse($account->canDebit($payment->getAmount()));
//    }
//
//    public function testCannotDebitWrongCurrency() {
//        $account = new BankAccount(100, 'USD');
//        $payment = new Payment(50, 'EUR');
//        $this->assertFalse($account->canDebit($payment->getAmount()));
//    }
//
//    public function testDebitIncrementsDailyDebitCount() {
//        $account = new BankAccount(100, 'USD');
//        $payment = new Payment(50, 'USD');
//        $account->debit($payment->getAmount());
//        $this->assertEquals(1, $account->getDailyDebitCount());
//    }
//}

