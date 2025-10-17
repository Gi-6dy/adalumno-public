@extends('layouts.app')

@section('title', 'Panel de Administración - Adalumnos')

@push('head')
    <style>
        .hero {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .hero h1 {
            font-size: 2.25rem;
            margin: 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #1c64f2, #0f172a);
            color: #fff;
            border-radius: 0.75rem;
            padding: 1.75rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.25);
        }

        .stat-card h2 {
            font-size: 1rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
            opacity: 0.8;
        }

        .stat-card p {
            font-size: 2.5rem;
            margin: 0;
            font-weight: 700;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 2rem;
        }

        .quick-actions a {
            background-color: #1c64f2;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .quick-actions a:hover {
            background-color: #174bcc;
        }
    </style>
@endpush

@section('content')
    <div class="hero">
        <div>
            <h1>Bienvenido a Adalumnos</h1>
            <p>Administra fácilmente la información de tus alumnos. Gestiona altas, ediciones y consultas desde un mismo lugar.</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h2>Total de alumnos</h2>
                <p>{{ number_format($totalAlumnos) }}</p>
            </div>
        </div>

        <div class="quick-actions">
            <a href="{{ route('alumnos.index') }}">Ver alumnos</a>
            <a href="{{ route('alumnos.create') }}">Registrar nuevo alumno</a>
        </div>
    </div>
@endsection
