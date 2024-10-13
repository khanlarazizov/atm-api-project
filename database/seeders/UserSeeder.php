<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();

        User::factory()->create([
            'name' => 'Admin',
            'account_number' => '1234567890123451',
            'balance' => 59,
            'pin' => Hash::make('1234'),
            'role' => RoleEnum::ADMIN,
        ]);

        User::factory()->create([
            'name' => 'User',
            'account_number' => '1234567890123452',
            'balance' => 59,
            'pin' => Hash::make('1234'),
            'role' => RoleEnum::USER,
        ]);

        User::factory()->create([
            'name' => 'Special User',
            'account_number' => '1234567890123453',
            'balance' => 59,
            'pin' => Hash::make('1234'),
            'role' => RoleEnum::SPECIAL_USER,
        ]);
    }
}
