@extends('layouts.app')

@section('title', 'Editar Alumno')

@section('content')
    <div class="card">
        <div class="user-info">
            <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
        </div>
        <h1>Editar Alumno</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Se encontraron errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumnos.update', $alumno) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="codigo">Código</label>
            <input
                type="text"
                id="codigo"
                name="codigo"
                value="{{ old('codigo', $alumno->codigo) }}"
                required
                minlength="9"
                maxlength="20"
                pattern="[0-9]{9,}"
                inputmode="numeric"
                title="El código debe contener solo dígitos y tener al menos 9 caracteres."
            >
            @error('codigo')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre', $alumno->nombre) }}"
                required
                minlength="3"
                maxlength="255"
                title="El nombre solo puede incluir letras, espacios, apóstrofes o guiones."
            >
            @error('nombre')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" value="{{ old('correo', $alumno->correo) }}" required>
            @error('correo')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', optional($alumno->fecha_nacimiento)->format('Y-m-d')) }}" required>
            @error('fecha_nacimiento')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="sexo">Sexo</label>
            <input type="text" id="sexo" name="sexo" value="{{ old('sexo', $alumno->sexo) }}" required>
            @error('sexo')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="carrera">Carrera</label>
            <input
                type="text"
                id="carrera"
                name="carrera"
                value="{{ old('carrera', $alumno->carrera) }}"
                required
                minlength="3"
                maxlength="4"
                pattern="[A-Za-z]{3,4}"
                title="La carrera debe contener entre 3 y 4 letras."
            >
            @error('carrera')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <button type="submit">Actualizar</button>
            <a href="{{ route('alumnos.show', $alumno) }}">Cancelar</a>
        </form>
    </div>
@endsection
