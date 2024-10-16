<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Models\Transaction;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteOwnTransaction
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = auth()->user();
            $transactionId = $request->route('transactionId');
            $transaction = Transaction::findOrFail($transactionId);

            if ($user->role !== RoleEnum::SPECIAL_USER) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only special users can delete transactions',
                ], 401);
            }

            if ($user->id !== $transaction->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'It is not your transaction',
                ], 401);
            }
            return $next($request);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        };
    }
}
