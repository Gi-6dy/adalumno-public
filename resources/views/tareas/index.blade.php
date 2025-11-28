@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Listado de Tareas')

@section('content')
    <style>
        /* Contenedor de paginación: centrar y separar elementos */
        .pagination,
        nav[role="navigation"] ul.pagination {
            display: flex !important;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 16px 0;
            justify-content: center;
            align-items: center;
        }

        /* Enlaces/elementos de la paginación (Bootstrap) */
        .pagination .page-item .page-link,
        .pagination a,
        .pagination span,
        nav[role="navigation"] a,
        nav[role="navigation"] span {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: #fff;
            color: #0d6efd;
            text-decoration: none;
            line-height: 1;
            font-size: 14px;
        }

        /* Hover */
        .pagination a:hover,
        nav[role="navigation"] a:hover {
            background: #f1f5f9;
            border-color: #d3dce6;
        }

        /* Estado activo */
        .pagination .active .page-link,
        .pagination .page-item.active .page-link,
        .pagination .active span,
        nav[role="navigation"] .active a,
        nav[role="navigation"] .active span {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        /* Estado deshabilitado */
        .pagination .disabled .page-link,
        .pagination .page-item.disabled .page-link,
        .pagination .disabled span,
        nav[role="navigation"] .disabled span {
            color: #6c757d;
            background: #fff;
            border-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.8;
        }

        /* Ajustes para paginación generada con Tailwind (clases utilitarias) */
        nav[role="navigation"] .relative,
        nav[role="navigation"] .flex {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Asegura que íconos SVG no rompan la altura */
        nav[role="navigation"] svg {
            height: 1rem;
            width: 1rem;
            vertical-align: middle;
        }

        @media (prefers-color-scheme: dark) {
            .pagination .page-item .page-link,
            .pagination a,
            .pagination span,
            nav[role="navigation"] a,
            nav[role="navigation"] span {
                border-color: #1f2937;
                background: #020617;
                color: #93c5fd;
            }

            .pagination a:hover,
            nav[role="navigation"] a:hover {
                background: #111827;
                border-color: #1f2937;
            }

            .pagination .active .page-link,
            .pagination .page-item.active .page-link,
            .pagination .active span,
            nav[role="navigation"] .active a,
            nav[role="navigation"] .active span {
                background: #2563eb;
                color: #e5e7eb;
                border-color: #2563eb;
            }

            .pagination .disabled .page-link,
            .pagination .page-item.disabled .page-link,
            .pagination .disabled span,
            nav[role="navigation"] .disabled span {
                color: #6b7280;
                background: #020617;
                border-color: #1f2937;
            }
        }

        html.theme-dark .pagination .page-item .page-link,
        html.theme-dark .pagination a,
        html.theme-dark .pagination span,
        html.theme-dark nav[role="navigation"] a,
        html.theme-dark nav[role="navigation"] span {
            border-color: #1f2937;
            background: #020617;
            color: #93c5fd;
        }

        html.theme-dark .pagination a:hover,
        html.theme-dark nav[role="navigation"] a:hover {
            background: #111827;
            border-color: #1f2937;
        }

        html.theme-dark .pagination .active .page-link,
        html.theme-dark .pagination .page-item.active .page-link,
        html.theme-dark .pagination .active span,
        html.theme-dark nav[role="navigation"] .active a,
        html.theme-dark nav[role="navigation"] .active span {
            background: #2563eb;
            color: #e5e7eb;
            border-color: #2563eb;
        }

        html.theme-dark .pagination .disabled .page-link,
        html.theme-dark .pagination .page-item.disabled .page-link,
        html.theme-dark .pagination .disabled span,
        html.theme-dark nav[role="navigation"] .disabled span {
            color: #6b7280;
            background: #020617;
            border-color: #1f2937;
        }
    </style>
    <div class="card">
        <div class="user-info">
            <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
        </div>
        <h1>Listado de tareas</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @auth
            <p>
                <a href="{{ route('tareas.create') }}">Crear tarea</a>
            </p>
        @endauth

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de entrega</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea->id }}</td>
                        <td>{{ $tarea->nombre }}</td>
                        <td>{{ Str::limit($tarea->descripcion, 80) }}</td>
                        <td>{{ $tarea->fecha_entrega->format('Y-m-d') }}</td>
                        <td>{{ $tarea->user?->name ?? 'Sin autor' }}</td>
                        <td class="actions">
                            <a href="{{ route('tareas.show', $tarea) }}">Ver</a>
                            @can('update', $tarea)
                                <a href="{{ route('tareas.edit', $tarea) }}">Editar</a>
                            @endcan
                            @can('delete', $tarea)
                                <form action="{{ route('tareas.destroy', $tarea) }}" method="POST" class="inline" onsubmit="return confirm('Deseas eliminar esta tarea?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Eliminar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay tareas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $tareas->links() }}
    </div>
@endsection
