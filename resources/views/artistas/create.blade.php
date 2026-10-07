@extends('adminlte::page')

@section('title', 'Nuevo Artista')

@section('content')

    <h1>Registrar Artista</h1>

    <form action="{{ route('artistas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre Artístico</label>
            <input type="text" name="nombre" class="form-control">
        </div>

        <div class="mb-3">
            <label>País de Origen</label>
            <input type="text" name="pais" class="form-control">
        </div>

        <div class="mb-3">
            <label>Género Principal</label>
            <input type="text" name="genero" class="form-control">
        </div>

        <div class="mb-3">
            <label>Biografía</label>
            <textarea name="biografia" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar
        </button>

    </form>

@stop
