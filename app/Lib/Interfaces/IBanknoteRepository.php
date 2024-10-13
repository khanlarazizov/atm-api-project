<?php

namespace App\Lib\Interfaces;

use App\Models\Banknote;
use Illuminate\Database\Eloquent\Collection;

interface IBanknoteRepository
{
    public function getAllBanknotes(): Collection;

    public function getBanknoteByID(int $id): Banknote;

    public function addBanknote(array $data, int $id): Banknote;
}
