<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seccion;

class SeccionSeeder extends Seeder
{
    public function run(): void
    {
        Seccion::factory()->count(20)->create();
    }
}
