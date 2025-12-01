@extends('layouts.app')

@section('title', 'Crear Tarea')

@section('content')
    <div class="card">
        <div class="user-info">
            <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
        </div>
        <h1>Crear Tarea</h1>

        <form action="{{ route('tareas.store') }}" method="POST" enctype="multipart/form-data">
            @include('tareas._form', ['submitLabel' => 'Crear'])
        </form>
    </div>
@endsection
