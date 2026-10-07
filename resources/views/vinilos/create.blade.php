@extends('adminlte::page')

@section('title', 'Nuevo Vinilo')

@section('content')

    <h1>Registrar Vinilo</h1>

    <form action="{{ route('vinilos.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <input type="text" name="titulo"
               class="form-control mb-2"
               placeholder="Título">

        <input type="text" name="genero"
               class="form-control mb-2"
               placeholder="Género">

        <input type="number" name="anio_lanzamiento"
               class="form-control mb-2"
               placeholder="Año">

        <input type="number" name="numero_canciones"
               class="form-control mb-2"
               placeholder="Número de canciones">

        <input type="number" step="0.01" name="precio"
               class="form-control mb-2"
               placeholder="Precio">

        <input type="number" name="stock"
               class="form-control mb-2"
               placeholder="Stock">

        <input type="text" name="formato"
               class="form-control mb-2"
               placeholder="Formato">

        <input type="text" name="discografia"
               class="form-control mb-2"
               placeholder="Discográfica">

        <textarea name="descripcion"
                  class="form-control mb-2"
                  placeholder="Descripción"></textarea>

        <div class="mb-3">
            <label>Imagen del Vinilo</label>
            <input type="file"
                   name="imagen"
                   class="form-control"
                   accept="image/*">
        </div>

        <select name="estado"
                class="form-control mb-2">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>

        <select name="artista_id"
                class="form-control mb-2">

            @foreach($artistas as $artista)
                <option value="{{ $artista->id }}">
                    {{ $artista->nombre }}
                </option>
            @endforeach

        </select>

        <button type="submit"
                class="btn btn-success">
            Guardar
        </button>

    </form>

@stop
