<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Seccion;
use Illuminate\Database\Seeder;

class SeccionSeeder extends Seeder
{
    private const DEFAULT_ALUMNOS_POR_SECCION = 5;
    private const TOTAL_SECCIONES = 20;

    public function run(): void
    {
        $secciones = Seccion::factory()
            ->count(self::TOTAL_SECCIONES)
            ->create();

        $alumnoIds = Alumno::pluck('id');

        if ($alumnoIds->isEmpty()) {
            return;
        }

        $alumnosPorSeccion = (int) env('ALUMNOS_POR_SECCION', self::DEFAULT_ALUMNOS_POR_SECCION);
        $alumnosPorSeccion = max(1, $alumnosPorSeccion);
        $alumnosPorSeccion = min($alumnosPorSeccion, $alumnoIds->count());

        $secciones->each(function (Seccion $seccion) use ($alumnoIds, $alumnosPorSeccion) {
            // Assign N random alumnos to each seccion
            $seccion->alumnos()->sync(
                $alumnoIds->random($alumnosPorSeccion)
            );
        });
    }
}
