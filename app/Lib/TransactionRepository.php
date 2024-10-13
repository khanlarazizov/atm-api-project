<?php

namespace App\Lib;

use App\Lib\Interfaces\ITransactionRepository;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Support\Facades\Log;

class TransactionRepository implements ITransactionRepository
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserTransactions(int $userId): Collection
    {
        try {
            $user = User::findOrFail($userId);
            return $user->transactions()->latest()->get();
        } catch (RelationNotFoundException $exception) {
            Log::error('User has no transactions', ['user_id' => $user->id, 'error' => $exception->getMessage()]);
            throw new RelationNotFoundException('User has no transactions');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param int $userId
     * @param $amount
     * @param $type
     * @return void
     */
    public function createTransaction(int $userId, $amount, $type): void
    {
        try {
            $user = User::findOrFail($userId);
            $user->transactions()->create([
                'amount' => $amount,
                'type' => $type,
                'date' => now()
            ]);
        } catch (RelationNotFoundException $exception) {
            Log::error('User has no transactions', ['user_id' => $user->id, 'error' => $exception->getMessage()]);
            throw new RelationNotFoundException('User has no transactions');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param int $transactionId
     * @return void
     * @throws \Exception
     */
    public function deleteTransaction(int $transactionId): void
    {
        try {
            $transaction = Transaction::findOrFail($transactionId);
            $transaction->delete();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new \Exception($exception->getMessage());
        }
    }
}
