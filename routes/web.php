<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\TareaController;
use App\Models\Alumno;
use App\Models\Seccion;
use App\Models\Tarea;
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
        $totalSecciones = Seccion::count();
        $totalTareas = Tarea::count();

        return Inertia::render('dashboard', [
            'alumnos' => $alumnos,
            'totalSecciones' => $totalSecciones,
            'totalTareas' => $totalTareas,
        ]);
    })->name('dashboard');

    Route::resource('alumnos', AlumnoController::class);
});

Route::resource('secciones', SeccionController::class, [
    'parameters' => ['secciones' => 'seccion']
]);
Route::resource('tareas', TareaController::class, [
    'middleware' => ['auth'],
    'except' => ['index', 'show']
]);
Route::get('tareas/eliminadas', [TareaController::class, 'trashed'])
    ->middleware('auth')
    ->name('tareas.trashed');
Route::resource('tareas', TareaController::class)->only(['index', 'show']);

Route::post('secciones/{seccion}/inscribir-alumno', [SeccionController::class, 'inscribirAlumno'])
    ->name('secciones.inscribir-alumno');
Route::get('secciones/{seccion}/desinscribir/{alumno}', [SeccionController::class, 'desinscribir'])
    ->name('secciones.desinscribir');
Route::delete('secciones/{seccion}/desinscribir/{alumno}', [SeccionController::class, 'desinscribir']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
