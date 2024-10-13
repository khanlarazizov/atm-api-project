<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawRequest;
use App\Services\WithdrawService;
use Illuminate\Http\JsonResponse;

class WithdrawController extends Controller
{
    /**
     * @param WithdrawService $withdrawService
     */
    public function __construct(protected WithdrawService $withdrawService)
    {
    }

    /**
     * @param WithdrawRequest $request
     * @return JsonResponse
     */
    public function __invoke(WithdrawRequest $request): JsonResponse
    {
        try {
            $data = $this->withdrawService->withdraw(\auth()->user(), $request->input('amount'));

            if ($data['success'] == true) {
                return response()->json([
                    'success' => true,
                    'banknotes' => $data['banknotes'],
                    'new_balance' => $data['new_balance'],
                    'withdraw_amount' => $data['withdraw_amount'],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $data['message'],
            ], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
