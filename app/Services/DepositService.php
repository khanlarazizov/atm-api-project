<?php

namespace App\Services;

use App\Enums\TransactionTypeEnum;
use App\Lib\Interfaces\IATMRepository;
use App\Models\Banknote;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositService
{
    public function __construct(protected IATMRepository $atmRepository)
    {
    }

    public function deposit(User $user, $depositAmount): array
    {
        $banknotes = $this->atmRepository->getAllBanknotesOrderByValue();
        $originalDepositAmount = $depositAmount;
        $banknoteCounts = [];

        DB::beginTransaction();

        try {
            $user->balance += $depositAmount;
            $user->save();

            $this->atmRepository->createTransaction($user->id, $depositAmount, TransactionTypeEnum::DEPOSIT);

            foreach ($banknotes as $banknote) {
                while ($depositAmount >= $banknote->value) {
                    $number = floor($depositAmount / $banknote->value);
                    $depositAmount -= $banknote->value * $number;
                    $banknote->quantity += $number;
                    $banknote->save();

                    isset($banknoteCounts[$banknote->value])
                        ? $banknoteCounts[$banknote->value] += $number
                        : $banknoteCounts[$banknote->value] = $number;
                }
            }


            DB::commit();
            return [
                'status' => 'success',
                'message' => 'Deposit successful',
                'banknotes' => $banknoteCounts,
                'new_balance' => $user->balance,
                'deposit_amount' => $originalDepositAmount
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Deposit failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
