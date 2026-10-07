@extends('adminlte::page')

@section('content')

    <div class="container mt-4">

        <h2>Editar Vinilo</h2>

        <form action="{{ route('vinilos.update', $vinilo->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Título</label>
                <input type="text"
                       name="titulo"
                       class="form-control"
                       value="{{ old('titulo', $vinilo->titulo) }}">
            </div>

            <div class="mb-3">
                <label>Género</label>
                <input type="text"
                       name="genero"
                       class="form-control"
                       value="{{ old('genero', $vinilo->genero) }}">
            </div>

            <div class="mb-3">
                <label>Año de lanzamiento</label>
                <input type="number"
                       name="anio_lanzamiento"
                       class="form-control"
                       value="{{ old('anio_lanzamiento', $vinilo->anio_lanzamiento) }}">
            </div>

            <div class="mb-3">
                <label>Número de canciones</label>
                <input type="number"
                       name="numero_canciones"
                       class="form-control"
                       value="{{ old('numero_canciones', $vinilo->numero_canciones) }}">
            </div>

            <div class="mb-3">
                <label>Precio</label>
                <input type="number"
                       step="0.01"
                       name="precio"
                       class="form-control"
                       value="{{ old('precio', $vinilo->precio) }}">
            </div>

            <div class="mb-3">
                <label>Stock</label>
                <input type="number"
                       name="stock"
                       class="form-control"
                       value="{{ old('stock', $vinilo->stock) }}">
            </div>

            <div class="mb-3">
                <label>Formato</label>
                <input type="text"
                       name="formato"
                       class="form-control"
                       value="{{ old('formato', $vinilo->formato) }}">
            </div>

            <div class="mb-3">
                <label>Discográfica</label>
                <input type="text"
                       name="discografia"
                       class="form-control"
                       value="{{ old('discografia', $vinilo->discografia) }}">
            </div>

            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion"
                          class="form-control"
                          rows="4">{{ old('descripcion', $vinilo->descripcion) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Artista</label>

                <select name="artista_id" class="form-control">

                    @foreach($artistas as $artista)

                        <option value="{{ $artista->id }}"
                            {{ $vinilo->artista_id == $artista->id ? 'selected' : '' }}>

                            {{ $artista->nombre }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div class="mb-3">

                <label>Imagen actual</label>

                <br>

                @if($vinilo->imagen)

                    <img src="{{ asset('storage/vinilos/'.$vinilo->imagen) }}"
                         width="150"
                         class="mb-2">

                @endif

                <input type="file"
                       name="imagen"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Estado</label>

                <select name="estado" class="form-control">

                    <option value="1"
                        {{ $vinilo->estado ? 'selected' : '' }}>
                        Activo
                    </option>

                    <option value="0"
                        {{ !$vinilo->estado ? 'selected' : '' }}>
                        Inactivo
                    </option>

                </select>

            </div>

            <button type="submit" class="btn btn-primary">
                Actualizar
            </button>

            <a href="{{ route('vinilos.index') }}"
               class="btn btn-secondary">
                Cancelar
            </a>

        </form>

    </div>

@endsection
