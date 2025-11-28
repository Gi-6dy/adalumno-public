@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Secciones</h1>
        <a href="{{ route('secciones.create') }}" class="btn btn-primary">Crear sección</a>
    </div>

    @if ($secciones->isEmpty())
        <p class="text-muted">No hay secciones registradas.</p>
    @else
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Sección</th>
                    <th>Aula</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($secciones as $seccion)
                    <tr>
                        <td>{{ $seccion->id }}</td>
                        <td>{{ $seccion->seccion }}</td>
                        <td>{{ $seccion->aula }}</td>
                        <td class="text-end">
                            <a href="{{ route('secciones.show', $seccion) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('secciones.edit', $seccion) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('secciones.destroy', $seccion) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta sección?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Si usas paginación --}}
        @if(method_exists($secciones, 'links'))
            {{ $secciones->links() }}
        @endif
    @endif
</div>
@endsection
