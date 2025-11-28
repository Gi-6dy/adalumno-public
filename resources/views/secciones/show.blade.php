@extends('layouts.app')

@section('content')
<div class="container">
    <div class="user-info">
        <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
    </div>
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $seccion->seccion }}</h1>
            <p class="text-muted">{{ $seccion->aula }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('secciones.edit', $seccion->seccion) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('secciones.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if ($message = Session::get('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <h3>Alumnos en esta sección</h3>
            @if ($seccion->alumnos->isEmpty())
                <p class="text-muted">No hay alumnos inscritos.</p>
            @else
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seccion->alumnos as $alumno)
                            <tr>
                                <td>{{ $alumno->nombre }}</td>
                                <td>{{ $alumno->correo ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('secciones.desinscribir', [$seccion, $alumno]) }}" class="btn btn-sm btn-danger"
                                       onclick="event.preventDefault(); document.getElementById('desinscribir-form-{{ $alumno->id }}').submit();">
                                        Desinscribir
                                    </a>
                                    <form id="desinscribir-form-{{ $alumno->id }}" action="{{ route('secciones.desinscribir', [$seccion, $alumno]) }}" method="GET" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="col-md-4">
            <h4>Inscribir alumno</h4>
            <form action="{{ route('secciones.inscribir-alumno', $seccion->seccion) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <select name="alumno_id" class="form-select @error('alumno_id') is-invalid @enderror" required>
                        <option value="">Seleccionar alumno...</option>
                        @foreach ($alumnosDisponibles as $alumno)
                            <option value="{{ $alumno->id }}">{{ $alumno->nombre }}</option>
                        @endforeach
                    </select>
                    @error('alumno_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success w-100">Inscribir</button>
            </form>
        </div>
    </div>
</div>
@endsection
