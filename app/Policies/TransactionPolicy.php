<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function view(User $authUser, User $accountUser): bool
    {
        return $authUser->id === $accountUser->id;
    }

    public function delete(User $authUser, Transaction $transaction): bool
    {
        return $authUser->id === $transaction->user_id;
    }
}
