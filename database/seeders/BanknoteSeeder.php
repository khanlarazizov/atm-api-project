<?php

namespace Database\Seeders;

use App\Enums\BanknoteEnum;
use App\Models\Banknote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanknoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (BanknoteEnum::cases() as $banknote) {
            Banknote::create(['value' => (string) $banknote->value, 'quantity' => rand(4, 10)]);
        }
    }
}
