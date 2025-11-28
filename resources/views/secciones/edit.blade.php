@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Editar Sección</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('secciones.update', $seccion) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="seccion" class="form-label">Sección</label>
                    <input
                        type="text"
                        class="form-control @error('seccion') is-invalid @enderror"
                        id="seccion"
                        name="seccion"
                        value="{{ old('seccion', $seccion->seccion) }}"
                        pattern="[A-Za-z0-9_][0-9]{2}"
                        title="Formato: un carácter alfanumérico o guión bajo seguido de 2 dígitos (ej: X12)"
                        required>
                    @error('seccion')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="aula" class="form-label">Descripción</label>
                    <input
                        type="text"
                        class="form-control @error('aula') is-invalid @enderror"
                        id="aula"
                        name="aula"
                        value="{{ old('aula', $seccion->aula) }}"
                        pattern="A[0-9]{3}"
                        title="Formato: letra A mayúscula seguida de 3 dígitos (ej: A123)"
                        required>
                    @error('aula')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('secciones.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
