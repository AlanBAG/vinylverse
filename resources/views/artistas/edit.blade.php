@extends('adminlte::page')

@section('content')

    <h1>Editar Artista</h1>

    <form action="{{ route('artistas.update',$artista->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text"
                   name="nombre"
                   class="form-control"
                   value="{{ $artista->nombre }}">
        </div>

        <div class="mb-3">
            <label>País</label>
            <input type="text"
                   name="pais"
                   class="form-control"
                   value="{{ $artista->pais }}">
        </div>

        <div class="mb-3">
            <label>Género</label>
            <input type="text"
                   name="genero"
                   class="form-control"
                   value="{{ $artista->genero }}">
        </div>

        <div class="mb-3">
            <label>Biografía</label>

            <textarea
                name="biografia"
                class="form-control">{{ $artista->biografia }}</textarea>
        </div>

        <button class="btn btn-primary">
            Actualizar
        </button>

    </form>

@stop
