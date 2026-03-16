<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'trainer@appgym.local'],
            [
                'name' => 'Entrenador Principal',
                'password' => 'password',
                'role' => User::ROLE_TRAINER,
                'is_active' => true,
            ]
        );
    }
}
