@extends('layouts.app')

@section('title', 'Editar Tarea')

@section('content')
    <div class="card">
        <div class="user-info">
            <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
        </div>
        <h1>Editar Tarea</h1>

        <form action="{{ route('tareas.update', $tarea) }}" method="POST">
            @method('PUT')
            @include('tareas._form', ['submitLabel' => 'Actualizar', 'tarea' => $tarea])
        </form>
    </div>
@endsection
