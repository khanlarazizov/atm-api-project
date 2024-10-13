<?php

namespace App\Lib\Interfaces;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ITransactionRepository
{
    public function getUserTransactions(int $userId): Collection;

    public function createTransaction(int $userId, $amount, $type);

    public function deleteTransaction(int $transactionId);
}
