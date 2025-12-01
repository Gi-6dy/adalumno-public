<?php

namespace Database\Seeders;

use App\Models\Tarea;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TareaSeeder extends Seeder
{
    private const TAREAS_POR_USUARIO = 3;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $users->each(function (User $user) {
            Tarea::factory()
                ->count(self::TAREAS_POR_USUARIO)
                ->for($user)
                ->create()
                ->each(function (Tarea $tarea) {
                    $filename = 'tareas/seeded-tarea-' . $tarea->id . '.txt';

                    Storage::disk('public')->put($filename, "Contenido de ejemplo para la tarea {$tarea->nombre}");

                    $tarea->update([
                        'adjunto' => $filename,
                    ]);
                });
        });
    }
}
