@extends('layouts.app')

@section('title', 'Crear Alumno')

@section('content')
    <div class="card">
        <div class="user-info">
            <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
        </div>
        <h1>Crear alumno</h1>

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

        <form action="{{ route('alumnos.store') }}" method="POST">
            @csrf

            <label for="codigo">Código</label>
            <input
                type="number"
                id="codigo"
                name="codigo"
                value="{{ old('codigo') }}"
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
                value="{{ old('nombre') }}"
                required
                minlength="3"
                maxlength="255"
                title="El nombre debe tener entre 3 y 255 caracteres."
            >
            @error('nombre')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required maxlength="255">
            @error('correo')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="user_id">Usuario asociado</label>
            <select id="user_id" name="user_id">
                <option value="">Sin usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (string) old('user_id') === (string) $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
            @error('fecha_nacimiento')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="sexo">Sexo</label>
            <select id="sexo" name="sexo" required>
                <option value="">Seleccionar...</option>
                <option value="Masculino" {{ old('sexo') === 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('sexo') === 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('sexo') === 'Otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('sexo')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <label for="carrera">Carrera</label>
            <select id="carrera" name="carrera" required>
                <option value="">Seleccionar...</option>
                @foreach(\App\Enums\Carrera::cases() as $c)
                    <option value="{{ $c->value }}" {{ old('carrera') === $c->value ? 'selected' : '' }}>
                        {{ $c->value }}
                    </option>
                @endforeach
            </select>
            @error('carrera')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <button type="submit">Guardar</button>
            <a href="{{ route('alumnos.index') }}">Cancelar</a>
        </form>
    </div>
@endsection
