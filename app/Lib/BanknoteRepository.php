<?php

namespace App\Lib;

use App\Lib\Interfaces\IBanknoteRepository;
use App\Models\Banknote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class BanknoteRepository implements IBanknoteRepository
{
    /**
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function getAllBanknotes(): Collection
    {
        try {
            $banknotes = Banknote::orderBy('value', 'desc')->get();
            return $banknotes;
        } catch (ModelNotFoundException $exception) {
            Log::error('Banknotes not found: ', ['error' => $exception->getMessage()]);
            throw new ModelNotFoundException('Banknotes not found');
        }
    }

    /**
     * @param int $id
     * @return Banknote
     * @throws ModelNotFoundException
     */
    public function getBanknoteByID(int $id): Banknote
    {
        try {
            return Banknote::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            Log::error('Banknote not found: ', ['banknote_id' => $id, 'error' => $exception->getMessage()]);
            throw new ModelNotFoundException('Banknote not found');
        }
    }

    /**
     * @param array $data
     * @param int $id
     * @return Banknote
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function addBanknote(array $data, int $id): Banknote
    {
        try {
            $banknote = Banknote::findOrFail($id);
            $banknote->quantity += $data['quantity'];
            $banknote->save();

            return $banknote;
        } catch (ModelNotFoundException $exception) {
            Log::error('Banknote not found: ', ['banknote_id' => $id, 'error' => $exception->getMessage()]);
            throw new ModelNotFoundException('Banknote not found');
        } catch (\Exception $exception) {
            Log::error('Banknote could not updated', ['banknote_id' => $id, 'error' => $exception->getMessage()]);
            throw new \Exception('Banknote could not updated');
        }
    }
}
