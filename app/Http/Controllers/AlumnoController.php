<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::orderBy('codigo')->paginate(10);

        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        Alumno::create($data);

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno creado correctamente.');
    }

    public function show(Alumno $alumno)
    {
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno)
    {
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $data = $this->validateData($request, $alumno->id);

        $alumno->update($data);

        return redirect()
            ->route('alumnos.show', $alumno)
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }

    private function validateData(Request $request, ?int $alumnoId = null): array
    {
        $correoRule = 'unique:alumnos,correo';
        if ($alumnoId) {
            $correoRule .= ',' . $alumnoId;
        }

        return $request->validate([
            'codigo' => ['required', 'string', 'regex:/^[0-9]{9,}$/'],
            'nombre' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\'\-]+$/u'],
            'correo' => ['required', 'email', 'max:255', $correoRule],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'sexo' => ['required', 'string', 'max:10'],
            'carrera' => ['required', 'string', 'alpha', 'min:3', 'max:4'],
        ]);
    }
}
