@extends('layouts.app')

@section('title', 'Listado de Alumnos')

@section('content')
    <div class="card">
        <h1>Listado de Alumnos</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <p>
            <a href="{{ route('alumnos.create') }}">Crear alumno</a>
        </p>

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alumnos as $alumno)
                    <tr>
                        <td>{{ $alumno->codigo }}</td>
                        <td>{{ $alumno->nombre }}</td>
                        <td>{{ $alumno->correo }}</td>
                        <td>{{ $alumno->carrera }}</td>
                        <td class="actions">
                            <a href="{{ route('alumnos.show', $alumno) }}">Ver</a>
                            <a href="{{ route('alumnos.edit', $alumno) }}">Editar</a>
                            <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="inline" onsubmit="return confirm('¿Deseas eliminar este alumno?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay alumnos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $alumnos->links() }}
    </div>
@endsection
