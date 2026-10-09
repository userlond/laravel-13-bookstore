<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => \Hash::make('password'),
            'role' => UserType::ADMIN->value,
        ]);

        User::factory()->count(10)->create([
            'role' => UserType::CUSTOMER->value,
        ]);
    }
}
