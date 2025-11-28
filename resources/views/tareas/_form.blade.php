@php
    $tarea = $tarea ?? null;
@endphp

@csrf

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

<label for="nombre">Nombre</label>
<input
    type="text"
    id="nombre"
    name="nombre"
    value="{{ old('nombre', $tarea->nombre ?? '') }}"
    required
    maxlength="255"
>
@error('nombre')
    <p class="text-danger">{{ $message }}</p>
@enderror

<label for="descripcion">Descripcion</label>
<textarea
    id="descripcion"
    name="descripcion"
    rows="4"
    required
>{{ old('descripcion', $tarea->descripcion ?? '') }}</textarea>
@error('descripcion')
    <p class="text-danger">{{ $message }}</p>
@enderror

<label for="fecha_entrega">Fecha de entrega</label>
<input
    type="date"
    id="fecha_entrega"
    name="fecha_entrega"
    value="{{ old('fecha_entrega', isset($tarea) && $tarea->fecha_entrega ? $tarea->fecha_entrega->format('Y-m-d') : '') }}"
    required
>
@error('fecha_entrega')
    <p class="text-danger">{{ $message }}</p>
@enderror

<button type="submit">{{ $submitLabel ?? 'Guardar' }}</button>
<a href="{{ route('tareas.index') }}">Cancelar</a>
