<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use App\Models\Alumno;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secciones = Seccion::all();
        return view('secciones.index', compact('secciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('secciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'seccion' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9_][0-9]{2}$/', 'unique:secciones,seccion'],
            'aula' => ['required', 'string', 'regex:/^A[0-9]{3}$/'],
        ]);

        Seccion::create($validated);

        return redirect()->route('secciones.index')->with('success', 'Sección creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Seccion $seccion)
    {
        $alumnosDisponibles = Alumno::whereDoesntHave('secciones', function ($query) use ($seccion) {
            $query->where('seccion_id', $seccion->id);
        })->orderBy('nombre')->get();
        return view('secciones.show', compact('seccion', 'alumnosDisponibles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seccion $seccion)
    {
        return view('secciones.edit', compact('seccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seccion $seccion)
    {
        $validated = $request->validate([
            'seccion' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9_][0-9]{2}$/', 'unique:secciones,seccion,' . $seccion->id],
            'aula' => ['required', 'string', 'regex:/^A[0-9]{3}$/'],
        ]);

        $seccion->update($validated);

        return redirect()->route('secciones.index')->with('success', 'Sección actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seccion $seccion)
    {
        $seccion->delete();

        return redirect()->route('secciones.index')->with('success', 'Sección eliminada exitosamente.');
    }

    public function inscribirAlumno(Request $request, Seccion $seccion)
    {
        $data = $request->validate([
            'alumno_id' => ['required', 'exists:alumnos,id'],
        ]);

        $seccion->alumnos()->syncWithoutDetaching([
            $data['alumno_id'] => [
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        return redirect()->route('secciones.show', $seccion)->with('status', 'Alumno inscrito.');
    }

    public function desinscribir(Request $request, Seccion $seccion, Alumno $alumno)
    {
        if ($request->isMethod('get')) {
            return view('secciones.desinscribir', compact('seccion', 'alumno'));
        }

        $seccion->alumnos()->detach($alumno->id);

        return redirect()->route('secciones.show', $seccion)->with('status', 'Alumno desinscrito.');
    }
}
