@extends('layouts.app')

@section('content')
<div class="container">
    <div class="user-info">
        <small>Usuario: <strong>{{ Auth::check() ? Auth::user()->name : 'Invitado' }}</strong></small>
    </div>
    <h1>Desinscribir alumno</h1>
    <div class="alert alert-warning">
        <p>¿Estás seguro que deseas desinscribir al alumno <strong>{{ $alumno->nombre }}</strong> de la sección <strong>{{ $seccion->seccion }}</strong>?</p>
    </div>
    <form method="POST" action="{{ route('secciones.desinscribir', [$seccion, $alumno]) }}">
        @csrf
        @method('DELETE')
        <a href="{{ route('secciones.show', $seccion) }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-danger">Desinscribir</button>
    </form>
</div>
@endsection
