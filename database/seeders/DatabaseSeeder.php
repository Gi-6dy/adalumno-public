<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Alumno;
use App\Models\Seccion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => Hash::make("admin"),
                'email_verified_at' => now(),
            ]
        );

        User::factory(10)->create();
        Alumno::factory(10)->create();
        Seccion::factory(10)->create();
    }
}
