<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\SeccionController;
use App\Models\Alumno;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $totalAlumnos = Alumno::count();
    $recentAlumnos = Alumno::latest('created_at')
        ->take(5)
        ->get(['id', 'nombre', 'codigo', 'carrera']);

    return Inertia::render('home', [
        'totalAlumnos' => $totalAlumnos,
        'recentAlumnos' => $recentAlumnos,
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $alumnos = Alumno::orderBy('nombre')
            ->get(['id', 'nombre', 'codigo', 'correo', 'carrera']);

        return Inertia::render('dashboard', [
            'alumnos' => $alumnos,
        ]);
    })->name('dashboard');

    Route::resource('alumnos', AlumnoController::class);
});

Route::resource('secciones', SeccionController::class, [
    'parameters' => ['secciones' => 'seccion']
]);

Route::post('secciones/{seccion}/inscribir-alumno', [SeccionController::class, 'inscribirAlumno'])
    ->name('secciones.inscribir-alumno');
Route::get('secciones/{seccion}/desinscribir/{alumno}', [SeccionController::class, 'desinscribir'])
    ->name('secciones.desinscribir');
Route::delete('secciones/{seccion}/desinscribir/{alumno}', [SeccionController::class, 'desinscribir']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
