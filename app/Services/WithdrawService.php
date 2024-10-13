<?php

namespace App\Services;

use App\Enums\TransactionTypeEnum;
use App\Lib\Interfaces\IATMRepository;
use App\Lib\Interfaces\IBanknoteRepository;
use App\Lib\Interfaces\ITransactionRepository;
use App\Models\Banknote;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawService
{
    /**
     * @param ITransactionRepository $transactionRepository
     * @param IBanknoteRepository $banknoteRepository
     */
    public function __construct(protected ITransactionRepository $transactionRepository, protected IBanknoteRepository $banknoteRepository)
    {
    }

    /**
     * @param User $user
     * @param $withdrawAmount
     * @return array
     */
    public function withdraw(User $user, $withdrawAmount): array
    {
        DB::beginTransaction();

        try {
            $banknotes = $this->banknoteRepository->getAllBanknotes();
            $banknoteCounts = [];
            $originalWithdrawAmount = $withdrawAmount;

            foreach ($banknotes as $banknote) {
                while ($withdrawAmount >= $banknote->value && $banknote->quantity > 0) {
                    $withdrawAmount -= $banknote->value;
                    $banknote->quantity--;

                    isset($banknoteCounts[$banknote->value])
                        ? $banknoteCounts[$banknote->value] += 1
                        : $banknoteCounts[$banknote->value] = 1;
                }
            }

            if ($withdrawAmount > 0) {
                DB::rollBack();
                Log::error('Unable to dispense the exact amount with available banknotes');
                return [
                    'success' => false,
                    'message' => 'Unable to dispense the exact amount with available banknotes',
                ];
            }

            $user->balance -= $originalWithdrawAmount;
            $user->save();

            foreach ($banknotes as $banknote) {
                $banknote->save();
            }

            $this->transactionRepository->createTransaction($user->id, $originalWithdrawAmount, TransactionTypeEnum::WITHDRAWAL->value);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Withdrawal successful',
                'banknotes' => $banknoteCounts,
                'new_balance' => $user->balance,
                'withdraw_amount' => $originalWithdrawAmount,
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Withdrawal failed: ' . $exception->getMessage());
            return [
                'success' => false,
                'message' => 'Withdrawal failed: ' . $exception->getMessage(),
            ];
        }
    }
}
