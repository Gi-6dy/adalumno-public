@extends('layouts.app')

@section('title', 'Detalle del Alumno')

@section('content')
    <div class="card">
        <h1>{{ $alumno->nombre }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <p><strong>Código:</strong> {{ $alumno->codigo }}</p>
        <p><strong>Correo:</strong> {{ $alumno->correo }}</p>
        <p><strong>Fecha de nacimiento:</strong> {{ $alumno->fecha_nacimiento?->format('d/m/Y') }}</p>
        <p><strong>Sexo:</strong> {{ $alumno->sexo }}</p>
        <p><strong>Carrera:</strong> {{ $alumno->carrera }}</p>

        <p>
            <a href="{{ route('alumnos.edit', $alumno) }}">Editar</a>
            <a href="{{ route('alumnos.index') }}">Volver al listado</a>
        </p>
    </div>
@endsection
