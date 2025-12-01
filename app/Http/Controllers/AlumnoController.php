<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\User;
use App\Enums\Carrera;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::orderBy('codigo')->paginate(10);

        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $users = $this->availableUsers();

        return view('alumnos.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $alumno = Alumno::create($data);

        $this->markUserAsAlumno($alumno->user, true);

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
        $users = $this->availableUsers($alumno);

        return view('alumnos.edit', compact('alumno', 'users'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $data = $this->validateData($request, $alumno->id);

        $previousUserId = $alumno->user_id;

        $alumno->update($data);

        if ($previousUserId && $previousUserId !== $alumno->user_id) {
            $this->markUserAsAlumno(User::find($previousUserId), false);
        }

        $this->markUserAsAlumno($alumno->user, true);

        return redirect()
            ->route('alumnos.show', $alumno)
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $user = $alumno->user;

        $alumno->delete();

        $this->markUserAsAlumno($user, false);

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

        // obtener los valores válidos del enum
        $carreraValues = array_map(fn($c) => $c->value, Carrera::cases());

        return $request->validate([
            'codigo' => ['required', 'numeric', 'digits_between:9,20'],
            'nombre' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s\'\-]+$/u'],
            'correo' => ['required', 'email', 'max:255', $correoRule],
            'fecha_nacimiento' => ['required', 'date', 'before:today'],
            'sexo' => ['required', 'string', 'max:10'],
            'carrera' => ['required', Rule::in($carreraValues)],
            'user_id' => [
                'nullable',
                'integer',
                'exists:users,id',
                Rule::unique('alumnos', 'user_id')->ignore($alumnoId),
            ],
        ]);
    }

    private function availableUsers(?Alumno $alumno = null)
    {
        $users = User::query()
            ->where(function ($query) {
                $query->whereNull('rol')
                    ->orWhere('rol', 'Alumno');
            })
            ->whereDoesntHave('alumno')
            ->orderBy('name')
            ->get();

        if ($alumno && $alumno->user) {
            $users->push($alumno->user);
            $users = $users->unique('id')->sortBy('name')->values();
        }

        return $users;
    }

    private function markUserAsAlumno(?User $user, bool $isAlumno): void
    {
        if (! $user) {
            return;
        }

        $user->forceFill([
            'rol' => $isAlumno ? 'Alumno' : null,
        ])->save();
    }
}
