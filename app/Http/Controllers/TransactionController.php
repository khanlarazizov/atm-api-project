<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Lib\Interfaces\ITransactionRepository;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * @param ITransactionRepository $transactionRepository
     */
    public function __construct(protected ITransactionRepository $transactionRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        try {
            $transactions = $this->transactionRepository->getUserTransactions(auth()->user()->id);

            return response()->json([
                'success' => true,
                'data' => TransactionResource::collection($transactions),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param int $transactionId
     * @return JsonResponse
     */
    public function destroy(int $transactionId): JsonResponse
    {
        try {
            $this->transactionRepository->deleteTransaction($transactionId);

            return response()->json([
                'message' => 'Transaction deleted',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
