<?php

namespace App\Http\Controllers;

use App\Mail\TareaCreada;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Tarea::query()
            ->withoutTrashed()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('tareas.index', compact('tareas'));
    }

    public function trashed(Request $request)
    {
        if (! $request->user() || $request->user()->name !== 'admin') {
            abort(403);
        }

        $tareas = Tarea::onlyTrashed()
            ->with('user')
            ->latest('deleted_at')
            ->paginate(10);

        return view('tareas.trashed', compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Tarea::class);

        return view('tareas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tarea::class);

        $data = $this->validateData($request);
        $this->uploadAdjunto($data);

        $tarea = $request->user()->tareas()->create($data);

        $this->enviarConfirmacion($tarea);

        return redirect()
            ->route('tareas.show', $tarea)
            ->with('success', 'Tarea creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        return view('tareas.show', compact('tarea'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        $this->authorize('update', $tarea);

        return view('tareas.edit', compact('tarea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        $this->authorize('update', $tarea);

        $data = $this->validateData($request);
        $this->uploadAdjunto($data, $tarea->adjunto);

        $tarea->update($data);

        return redirect()
            ->route('tareas.show', $tarea)
            ->with('success', 'Tarea actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $this->authorize('delete', $tarea);

        $tarea->delete();

        return redirect()
            ->route('tareas.index')
            ->with('success', 'Tarea eliminada correctamente.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'fecha_entrega' => ['required', 'date'],
            'adjunto' => ['nullable', 'file', 'mimes:pdf,zip,docx,txt'],
        ]);
    }

    private function uploadAdjunto(array &$data, ?string $previousPath = null): void
    {
        if (! array_key_exists('adjunto', $data)) {
            return;
        }

        if ($previousPath) {
            Storage::disk('public')->delete($previousPath);
        }

        $data['adjunto'] = $data['adjunto']->store('tareas', 'public');
    }

    private function enviarConfirmacion(Tarea $tarea): void
    {
        $tarea->loadMissing('user.alumno');

        $user = $tarea->user;

        if (! $user) {
            return;
        }

        $correo = $user->email ?: ($user->alumno->correo ?? null);

        if (! $correo) {
            return;
        }

        Mail::to($correo)->send(new TareaCreada($tarea));
    }
}
