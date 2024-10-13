<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBanknoteRequest;
use App\Http\Resources\BanknoteResource;
use App\Lib\Interfaces\IBanknoteRepository;
use App\Models\Banknote;
use Illuminate\Http\JsonResponse;

class BanknoteController extends Controller
{
    /**
     * @param IBanknoteRepository $banknoteRepository
     */
    public function __construct(protected IBanknoteRepository $banknoteRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $banknotes = $this->banknoteRepository->getAllBanknotes();

            return response()->json([
                'success' => true,
                'data' => BanknoteResource::collection($banknotes)
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param Banknote $banknote
     * @return JsonResponse
     */
    public function show(Banknote $banknote): JsonResponse
    {
        try {
            $banknote = $this->banknoteRepository->getBanknoteByID($banknote->id);

            return response()->json([
                'success' => true,
                'data' => BanknoteResource::make($banknote)
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param UpdateBanknoteRequest $request
     * @param Banknote $banknote
     * @return JsonResponse
     */
    public function update(UpdateBanknoteRequest $request, Banknote $banknote)
    {
        try {
            $banknote = $this->banknoteRepository->addBanknote($request->validated(), $banknote->id);

            return response()->json([
                'success' => true,
                'data' => BanknoteResource::make($banknote)
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
