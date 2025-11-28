@extends('layouts.app')

@section('title', 'Detalle de tarea')

@section('content')
    <div class="card">
        <div class="user-info">
            <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
        </div>
        <h1>{{ $tarea->nombre }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <p><strong>Descripcion:</strong> {{ $tarea->descripcion }}</p>
        <p><strong>Fecha de entrega:</strong> {{ $tarea->fecha_entrega->format('Y-m-d') }}</p>
        <p><strong>Autor:</strong> {{ $tarea->user?->name ?? 'Sin autor' }}</p>

        <p>
            <a href="{{ route('tareas.index') }}">Volver al listado</a>
            @can('update', $tarea)
                <a href="{{ route('tareas.edit', $tarea) }}">Editar</a>
            @endcan
        </p>

        @can('delete', $tarea)
            <form action="{{ route('tareas.destroy', $tarea) }}" method="POST" class="inline" onsubmit="return confirm('Deseas eliminar esta tarea?');">
                @csrf
                @method('DELETE')
                <button type="submit">Eliminar</button>
            </form>
        @endcan
    </div>
@endsection
