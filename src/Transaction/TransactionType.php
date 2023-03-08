<?php
declare(strict_types=1);

namespace App\Transaction;

enum TransactionType
{
    case CREDIT;
    case DEBIT;
}
