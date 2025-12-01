@extends('layouts.app')

@section('title', 'Editar Alumno')

@section('content')
    <div class="card">
        <div class="user-info">
            <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
        </div>
        <h1>Editar alumno</h1>

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
                type="number"
                id="codigo"
                name="codigo"
                value="{{ old('codigo', $alumno->codigo) }}"
                required
                min="100000000"
                title="El código debe ser un número de al menos 9 dígitos."
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
                title="El nombre debe tener entre 3 y 255 caracteres."
            >
            @error('nombre')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" value="{{ old('correo', $alumno->correo) }}" required maxlength="255">
            @error('correo')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="user_id">Usuario asociado</label>
            <select id="user_id" name="user_id">
                <option value="">Sin usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (string) old('user_id', $alumno->user_id) === (string) $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', optional($alumno->fecha_nacimiento)->format('Y-m-d')) }}" required>
            @error('fecha_nacimiento')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="sexo">Sexo</label>
            <select id="sexo" name="sexo" required>
                <option value="">Seleccionar...</option>
                <option value="Masculino" {{ old('sexo', $alumno->sexo) === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('sexo', $alumno->sexo) === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('sexo', $alumno->sexo) === 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('sexo')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="carrera">Carrera</label>
            <select id="carrera" name="carrera" required>
                <option value="">Seleccionar...</option>
                @php
                    $selectedCarrera = old('carrera', isset($alumno) ? ($alumno->carrera?->value ?? $alumno->carrera) : null);
                @endphp
                @foreach(\App\Enums\Carrera::cases() as $c)
                    <option value="{{ $c->value }}" {{ $selectedCarrera === $c->value ? 'selected' : '' }}>
                        {{ $c->value }}
                    </option>
                @endforeach
            </select>
            @error('carrera')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <button type="submit">Actualizar</button>
            <a href="{{ route('alumnos.show', $alumno) }}">Cancelar</a>
        </form>
    </div>
@endsection
